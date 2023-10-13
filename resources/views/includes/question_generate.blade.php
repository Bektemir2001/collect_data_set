<div>
    <div id="questions_id">
        @foreach($context->questions as $question)
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{'Question '.$loop->iteration}}</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="question{{$question->id}}">question:</label>
                            <input type="text" class="form-control" id="question{{$question->id}}" value="{{$question->question}}">
                        </div>
                        <div class="form-group">
                            <label for="answer{{$question->id}}">answer:</label>
                            <textarea class="form-control" id="answer{{$question->id}}">{{$question->answer}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2" onclick="updateQuestion({{$question->id}})">Update</button>
                        <button type="submit" class="btn bg-danger">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-success mr-2" onclick="addQuestion()">Add question</button>
    <button type="submit" class="btn btn-primary mr-2" onclick="autoGenerate()">Generate questions with GPT 3.5</button>
</div>

<script>
    let count_of_questions = {{count($context->questions)}};
    let un_saved_questions = [];
    let current_context_array = splitTextIntoChunks(`{{$context_text}}`, 2500);
    console.log(current_context_array);
    function updateQuestion(question_id)
    {
        let question = document.getElementById(`question${question_id}`);
        let answer = document.getElementById(`answer${question_id}`);
        if(question.value !== '' && answer.value !== '')
        {
            console.log(question.value);
            console.log(answer.value);
        }
    }

    function splitTextIntoChunks(text, chunkSize) {
        let chunks = [];
        let words = text.split(' ');

        for (let i = 0; i < words.length; i++) {
            let currentChunk = words[i];

            while (i + 1 < words.length && (currentChunk + ' ' + words[i + 1]).length <= chunkSize) {
                i++;
                currentChunk += ' ' + words[i];
            }

            chunks.push(currentChunk);
        }

        return chunks;
    }
    function addQuestion()
    {
        let newElement = document.createElement("div");
        newElement.className = 'card';
        let div = document.getElementById("questions_id");
        count_of_questions += 1;
        newElement.innerHTML = `<div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Question${count_of_questions}</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="questionNew${count_of_questions}">question:</label>
                            <input type="text" class="form-control" id="questionNew${count_of_questions}">
                        </div>
                        <div class="form-group">
                            <label for="answerNew${count_of_questions}">answer:</label>
                            <input type="text" class="form-control" id="answerNew${count_of_questions}">
                        </div>
                        <button type="button" class="btn btn-success mr-2" id="newButton${count_of_questions}" onclick="saveQuestion(${count_of_questions})">Save</button>
                        <button type="submit" class="btn bg-danger">Remove</button>
                </div>`;
        div.appendChild(newElement);
    }
    function saveQuestion(question_id)
    {
        let question = document.getElementById(`questionNew${question_id}`);
        let answer = document.getElementById(`answerNew${question_id}`);
        if(question.value !== '' && answer.value !== ''){
            let data = new FormData();
            data.append('question', question.value);
            data.append('answer', answer.value);
            data.append('context_id', {{$context->id}});
            let url = "{{route('question.store')}}";
            fetch(url, {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                body: data
            })
                .then(response => response.json())
                .then(res => {
                    res = res.data;
                    let button = document.getElementById(`newButton${question_id}`);
                    button.innerHTML = 'Update';
                    button.onclick = `updateQuestion(${res.id})`;
                    button.className = 'btn btn-primary mr-2';
                    question.id = `question${res.id}`;
                    answer.id = `answer${res.id}`;
                });
        }
        else{
            alert('empty question or answer');
        }

    }


    function autoGenerate()
    {
        let url = "{{route('question.autogenerate')}}";
        for(let i = 0; i < current_context_array.length; i++)
        {
            let data = new FormData();
            data.append('context_id', {{$context->id}});
            data.append('text', current_context_array[i]);
            if(current_context_array[i].length > 100){
                fetch(url, {
                    method:'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    body: data
                })
                    .then(response => response.json())
                    .then(res => {
                        res = res.data;
                        for(let i = 0; res.length; i++)
                        {
                            addGeneratedQuestion(res[i]);
                        }
                    });
            }
        }
    }

    function addGeneratedQuestion(object)
    {
        let newElement = document.createElement("div");
        newElement.className = 'card';
        let div = document.getElementById("questions_id");
        count_of_questions += 1;
        newElement.innerHTML = `<div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Question${count_of_questions}</h4>
                    </div>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="question${object.id}">question:</label>
                            <input type="text" class="form-control" id="question${object.id}">
                        </div>
                        <div class="form-group">
                            <label for="answer${object.id}">answer:</label>
                            <input type="text" class="form-control" id="answer${object.id}" value="${object.answer}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2" onclick="updateQuestion(${object.id})">Update</button>
                        <button type="submit" class="btn bg-danger">Remove</button>
                </div>`;
        div.appendChild(newElement);
    }

    function removeQuestion(question_id, is_new=false)
    {
        if(is_new)
        {

        }
    }
</script>

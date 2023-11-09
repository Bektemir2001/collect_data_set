<div>
    <div id="questions_id">
        @foreach($context->questions as $question)
            <div class="card" id="{{'card'.$question->id}}">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{'Question '.$loop->iteration}}</h4>
                    </div>
                </div>
                <div class="card-body">
                        @if($question->original_question)
                        <div class="form-group">
                            <label for="original_question{{$question->id}}">original question:</label>
                            <input type="text" class="form-control" id="original_question{{$question->id}}" value="{{$question->original_question}}">
                        </div>
                        @endif
                        @if($question->original_answer)
                                <div class="form-group">
                                    <label for="original_answer{{$question->id}}">original answer:</label>
                                    <textarea class="form-control" id="original_answer{{$question->id}}">{{$question->original_answer}}</textarea>
                                </div>
                            @endif
                            <div class="form-group">
                            <label for="question{{$question->id}}">question:</label>
                            <input type="text" class="form-control" id="question{{$question->id}}" value="{{$question->question}}">
                        </div>
                        <div class="form-group">
                            <label for="answer{{$question->id}}">answer:</label>
                            <textarea class="form-control" id="answer{{$question->id}}">{{$question->answer}}</textarea>
                        </div>
                        <button type="button" class="btn btn-primary mr-2" onclick="updateQuestion({{$question->id}})">Update</button>
                        <button type="button" class="btn bg-danger" onclick="removeQuestion({{$question->id}})">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-success mr-2" onclick="addQuestion()">Add question</button>
    <button type="submit" class="btn btn-primary mr-2" onclick="autoGenerate()">Generate questions with GPT 3.5</button>
    <button type="submit" class="btn btn-primary mr-2" onclick="autoGenerateGpt4()">Generate questions with GPT 4</button>
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
            let url = "{{route('question.update')}}";
            let data = new FormData()
            data.append('answer', answer.value);
            data.append('question', question.value);
            data.append('question_id', question_id);
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                body: data
            })
                .then(response => response.json())
                .then(res => {
                        alert(res.data);
                });
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
        count_of_questions += 1;
        let newElement = document.createElement("div");
        newElement.className = 'card';
        newElement.id = 'cardNew' + count_of_questions;
        let div = document.getElementById("questions_id");
        newElement.innerHTML = `<div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Question ${count_of_questions}</h4>
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
                        <button type="button" class="btn bg-danger" id="newRemoveButton${count_of_questions}" onclick="removeQuestion(${count_of_questions}, true)">Remove</button>
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
                    button.outerHTML = `<button type="button" class="btn btn-primary mr-2" onclick="updateQuestion(${res.id})">Update</button>`
                    let removeButton = document.getElementById(`newRemoveButton${question_id}`);
                    removeButton.outerHTML = `<button type="button" class="btn bg-danger" onclick="removeQuestion(${res.id})">Remove</button>`;
                    question.id = `question${res.id}`;
                    answer.id = `answer${res.id}`;
                    let card = document.getElementById(`cardNew${question_id}`);
                    card.id = `card${res.id}`;
                    console.log(res);
                });
            console.log(question_id);
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
    function autoGenerateGpt4()
    {
        let url = "{{route('gpt4.question.generate')}}";
        let data = new FormData();
        data.append('context_id', {{$context->id}});
        fetch(url, {
            method:'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            },
            body: data
        })
            .then(response => response.json())
            .then(res => {
                if(res.status_code === 200) document.location.reload();
                else alert(res.data);

            });

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
                            <input type="text" class="form-control" id="question${object.id}" value="${object.question}">
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
        console.log('click')
        if(is_new)
        {
            document.getElementById('cardNew'+question_id).outerHTML = '';
            count_of_questions -= 1;
        }
        else{
            url = "{{route('question.remove')}}";
            let data = new FormData();
            data.append('question_id', question_id);
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                body: data
            })
                .then(response => response.json())
                .then(res => {
                    if(res.code === 200)
                    {
                        count_of_questions -= 1;
                        alert(res.data);
                        document.getElementById('card'+question_id).outerHTML = '';
                        let div = document.getElementById('questions_id');
                        let divs = div.children;
                        for(let i = 0; i < divs.length; i++){
                            divs[i].children[0].children[0].children[0].innerHTML = 'Question ' + (i+1);
                        }
                    }
                    else{
                        alert(res.data);
                    }
                });
        }

    }


</script>

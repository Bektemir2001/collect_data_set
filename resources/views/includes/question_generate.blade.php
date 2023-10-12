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
                            <input type="text" class="form-control" id="answer{{$question->id}}" value="{{$question->answer}}">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2" onclick="updateQuestion({{$question->id}})">Update</button>
                        <button type="submit" class="btn bg-danger">Remove</button>
                </div>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-success mr-2" onclick="addQuestion()">Add question</button>
    <a type="submit" class="btn bg-danger">Cancel</a>
</div>

<script>
    let count_of_questions = {{count($context->questions)}};
    let un_saved_questions = [];
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
                        <button type="submit" class="btn btn-success mr-2" onclick="saveQuestion(${count_of_questions})">Save</button>
                        <button type="submit" class="btn bg-danger">Remove</button>
                </div>`;

        div.appendChild(newElement);
        let question_object = {
            'id': count_of_questions,
            'question': document.getElementById(`questionNew${count_of_questions}`),
            'answer': document.getElementById(`answerNew${count_of_questions}`)
        }
        un_saved_questions.push(question_object);
    }

    function autoGenerateQuestions()
    {

    }
    function saveQuestion(question_id)
    {
        console.log(question_id);
    }
</script>

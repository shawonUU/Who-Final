<div class="row align-items-center my-4">

    <div class="container-fluid">
        <div class="section-title">
            <h2>Quiz</h2>
        </div>
    </div>

    <div class="col-md-9 mx-auto">
        <div class="card">
            <div class="card-body">
                <form id="course_quiz_modal_form" class="course_quiz_modal_form" method="post"
                    enctype="multipart/form-data">@csrf
                    <div class="quiz-section row p-5">
                        <?php $index = 1;
                        $total_quiz = $quizes->count(); ?>

                        @forelse ($quizes as $key => $quiz)
                            <input type="hidden" value="{{ $quiz->id }}" name="questions[]" />
                            <?php $res_variable = 'results[' . $quiz->id . ']'; ?>
                            <input type="hidden" value="{{ old($res_variable) }}" name="{{ $res_variable }}" />
                            <input type="hidden" value="{{ $quiz->type }}" name="question_types[]" />
                            <input type="hidden" value="{{ $module_id }}" name="module_id" />
                                <div class="col-md-6 text-center">
                                    @if ($quiz->type == 'radio')
                                        <!--When Radio Button -->
                                        <div class="question-title pb-1 mb-1">
                                            <p>
                                                <span>{{ $index++ }}.</span>
                                                {{ $quiz->question_title }}
                                            </p>
                                        </div>
                                        <div class="question-option pb-2 mb-2">
                                            <ul style="list-style-type: none;">
                                                @foreach ($quiz->options as $option)
                                                    <li class="list-group-item">
                                                        <input type="radio" value="{{ $option->id }} "
                                                            name="options[{{ $quiz->id }}][]" class=" ml-3"
                                                            onclick="calculateResult({{ $option->correct_answer }},{{ $quiz->id }})">
                                                        <b>{{ $option->option_text }}</b>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if ($quiz->type == 'checkbox')
                                        <!--When checkbox -->
                                        <div class="question-title pb-1 mb-1">
                                            <p>
                                                <span>{{ $index++ }}.</span>
                                                {{ $quiz->question_title }}
                                            </p>
                                        </div>
                                        <div class="question-option pb-2 mb-2">
                                            <ul style="list-style-type: none;">
                                                @foreach ($quiz->options as $option)
                                                    <li class="list-group-item">
                                                        <input type="checkbox" value="{{ $option->id }} "
                                                            name="options[{{ $quiz->id }}][]" class=" ml-3"
                                                            onclick="calculateResult({{ $option->correct_answer }},{{ $quiz->id }})">
                                                        <b>{{ $option->option_text }}</b>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <hr />
                                    @endif
                                </div>
                            @empty
                                <div class="text-center">
                                    <h3 class="text-center text-white">No Quiz Available!</h3>
                                </div>
                        @endforelse
                    </div>
                    @if($total_quiz)
                    <div class="text-center py-3">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

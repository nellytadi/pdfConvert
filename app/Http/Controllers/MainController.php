<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;

class MainController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'pdfFile' => 'required|mimes:pdf|max:10000'
        ]);

        $text = (new Pdf('c:/Program Files/Git/mingw64/bin/pdftotext'))
            ->setPdf($request->file('pdfFile'))
            ->text();

        $questions = preg_split("/[\d][.]/", $text);

        $answers = [];
        foreach ($questions as $question) {
            $answers[] = preg_split("/[A-E][.][\s ]/", $question);
        }

        unset($answers[0]);
        dd($answers);
        foreach ($answers as $answer) {
            if ($answer[0]) {
                $question = Question::create([
                    'question' => $answer[0]
                ]);
            }
            if ($answer[1]) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => 'A',
                    'answer' => $answer[1]
                ]);
            }
            if ($answer[2]) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => 'B',
                    'answer' => $answer[2]
                ]);
            }
            if ($answer[3]) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => 'C',
                    'answer' => $answer[3]
                ]);
            }
            if ($answer[4]) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => 'D',
                    'answer' => $answer[4]
                ]);
            }
            if ($answer[5]) {
                Answer::create([
                    'question_id' => $question->id,
                    'option' => 'E',
                    'answer' => $answer[5]
                ]);
            }
        }
    }

}

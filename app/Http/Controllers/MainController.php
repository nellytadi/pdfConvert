<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Correct;
use App\Question;
use Illuminate\Http\Request;
use Spatie\PdfToText\Pdf;

class MainController extends Controller
{

    public function create()
    {
        $questions = Question::all();
        $questions = collect($questions)->map(function($question){
            $question->correct = Correct::where('question_id',$question->id)->pluck('correct_answer')->first();
            return $question;
        });
        return view('main', compact('questions'));
    }

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
        foreach ($answers as $answer) {
            if (count($answer) == 6) {


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
        return redirect()->route('main.app');
    }

    public function answer(Request $request)
    {
//        dd($request);
        $correct=Correct::where('question_id',$request->input('id'))->first();
        if ($correct){
            $correct = Correct::where('question_id',$request->input('id'))->first();
            $correct->correct_answer = $request->input('option');
            $correct->save();
        }
        else{
            Correct::create([
                'question_id' => $request->input('id'),
                'correct_answer'=> $request->input('option')
            ]);
        }

    }
}

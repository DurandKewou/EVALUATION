<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\ExamAnswer;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // add subject
    public function addSubject(Request $request)
    {
        try {
            Subject::insert([
                'subject'=> $request->subject
            ]);

            return response()->json(['success'=>true,'msg'=>'Subject added Sucessfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //edit subject
    public function editSubject(Request $request)
    {
        try {
            
            $subject = Subject::find($request->id);
            $subject->subject = $request->subject;
            $subject->save();

            return response()->json(['success'=>true,'msg'=>'Subject updated Sucessfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function deleteSubject(Request $request)
    {
        try {

            Subject::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Subject deleted Sucessfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //exam function load
    public function examDashboard()
    {
        $subjects = Subject::all();
        $exams = Exam::with('subjects')->get();
        return view('admin.exam-dashboard', ['subjects'=>$subjects,'exams'=>$exams]);
    }

    //add exam
    public function addExam(Request $request)
    {
        try {

            $unique_id = uniqid('exid');
            Exam::insert([
                'exam_name'=> $request->exam_name,
                'subject_id'=> $request->subject_id,
                'date'=> $request->date,
                'time'=> $request->time,
                'attempt'=> $request->attempt,
                'enterance_id' => $unique_id,
            ]);
            return response()->json(['success'=>true,'msg'=>'Exam added Sucessfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        };
    }

    public function getExamDetail($id)
    {
        try {

            $exam = Exam::where('id',$id)->get();
            return response()->json(['success'=>true,'data'=>$exam]);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //Edit Exam

    public function updateExam(Request $request)
    {
        try {

            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->date = $request->date;
            $exam->time = $request->time;
            $exam->attempt = $request->attempt;
            $exam->save();
            return response()->json(['success'=>true,'msg'=>'Exam update successful!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function deleteExam(Request $request)
    {
        try {

            Exam::where('id',$request->exam_id)->delete();
            return response()->json(['success'=>true,'msg'=>'Exam deleted Sucessfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //add Q&A
    public function qnaDashboard()
    {
        $questions = Question::with('answers')->get();
        return view('admin.qnaDashboard',compact('questions'));
    }

    public function addQna(Request $request){
        try {

            $explaination = null;

            if (isset($request->explaination)) {
                $explaination = $request->explaination;
            }
            $questionId = Question::insertGetId([
                'question' => $request->question,
                'explaination' => $explaination
            ]);
            foreach ($request->answers as $answer ) {

                $is_correct = 0;

                if ($request ->is_correct == $answer ) {
                    $is_correct = 1;
                }
                Answer::insert([
                    'questions_Id' =>$questionId,
                    'answer' =>$answer,
                    'is_correct' =>$is_correct
                ]);
            }

            return response()->json(['success'=>true,'msg'=>'Question and Answer added Sucessfully!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        };
    }

    public function getQnaDetails(Request $request){
        $qna = Question::where('id',$request->qid)->with('answers')->get();

        return response()->json(['data'=>$qna]);
    }

    public function deleteAns(Request $request){
        Answer::Where('id',$request->id)->delete();
        return response()->json(['success'=>true,'msg'=>'Answer deleted successfully']);
    }

    public function updateQna(Request $request){
        $explaination = null;

        if (isset($request->explaination)) {
            $explaination = $request->explaination;
        }

        try {
            Question::where('id',$request->question_id)->update([
                'question' => $request->question,
                'explaination' =>$explaination
            ]);
            
            if (isset($request->answers)) {
                foreach ($request->answers as $key => $value) {
                    $is_correct = 0;
                    if ($request->is_correct == $value) {
                        $is_correct=1;
                    }
                    Answer::where('id',$key)->update([
                        'questions_id' => $request->question_id,
                        'answer' => $value,
                        'is_correct' =>$is_correct
                    ]);
                }
            }

            //new answer
            if (isset($request->new_answers)) {
                foreach ($request->new_answers as $answer) {
                    $is_correct = 0;
                    if ($request->is_correct == $answer) {
                        $is_correct=1;
                    }
                    Answer::insert([
                        'questions_id' => $request->question_id,
                        'answer' => $answer,
                        'is_correct' =>$is_correct
                    ]);
                }
            }

            return response()->json(['success'=>true,'msg'=>'Q&A updated successfully']);
            
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        };
    }

    public function deleteQna(Request $request){
        try {
            Question::where('id',$request->id)->delete();
            Answer::where('questions_id',$request->id)->delete();

            return response()->json(['success'=>true,'msg'=>'Q&A deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        };
        
    }

    //Student
    public function studentsDashboard(){
        $students = User::where('is_admin',0)->get();
        return view('admin.studentsDashboard',compact('students'));
    }

    //add Students
    public function addStudent(Request $request){
        try {
            $password = Str::random(8);

            User::insert([
                'name'=>$request->name,
                'email'=>$request->email,
                'password' =>Hash::make($password),
            ]);

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['title'] ="Student Registration on UYQUIZ";

            Mail::send('registrationMail',['data'=>$data],function ($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success'=>true,'msg'=>'Student added succesfully']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        };
    }

    public function editStudent(Request $request){
        try {

            $user = User::find($request->id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['title'] ="Update Student Prifil on UYQUIZ";

            Mail::send('UpdateProfileMail',['data'=>$data],function ($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });

            return response()->json(['success'=>true,'msg'=>'Student update succesfully']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }; 
    }

    //delete student
    public function deleteStudent(Request $request){
        try {
            User::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Student deleted successfully !']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }; 
    }

    //Qna Exam
    public function getQuestion(Request $request){
        try {
           $questions = Question::all();

           if (count($questions)>0) {
                $data = [];
                $counter = 0;
                foreach ($questions as $question) {
                   $qnaExam =QnaExam::where(['exam_id'=> $request->exam_id,'question_id' => $request->question_id])->get();
                   if (count($qnaExam)==0) {
                        $data[$counter]['id']=$question->id;
                        $data[$counter]['questions']=$question->question;
                        $counter++;
                   }
                }
                return response()->json(['success'=>true,'msg'=>'Questions data!','data'=>$data]);
           }else{
            return response()->json(['success'=>false,'msg'=>"Question not Found !"]);
           }
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }

    public function addQuestion(Request $request){
        try {
            if (isset($request->questions_ids)) {
                foreach ($request->questions_ids as $qid) {
                    QnaExam::insert([
                        'exam_id' => $request->exam_id,
                        'question_id' => $qid,
                    ]);
                }
            }
            return response()->json(['success'=>true,'msg'=>'Questions add successfully']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }

    public function getExamQuestion(Request $request){
        try {
            $data = QnaExam::where('exam_id',$request->exam_id)->with('question')->get();
            return response()->json(['success'=>true,'msg'=>'Questions details','data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }

    public function deleteExamQuestion(Request $request){
        try {
            $data = QnaExam::where('id',$request->exam_id)->delete();
            return response()->json(['success'=>true,'msg'=>'Questions deleted!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }

    public function loadMarks(){
        $exams = Exam::with('getQnaExam')->get();
        return view('admin.marksDashboard',compact('exams'));
    }

    public function updateMarks(Request $request){
        try {
            Exam::where('id',$request->exam_id)->update([
                'marks'=> $request->marks,
                'pass_marks' =>$request->pass_marks,
            ]);
            return response()->json(['success'=>true,'msg'=>'Marks Updated!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }

    public function reviewExams(){
        $attempts = ExamAttempt::with(['user','exam'])->orderBy('id')->get();

        return view('admin.review-exams',compact('attempts'));
    }

    public function reviewQna(Request $request){
        
        try {
            $attemptData = ExamAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();
            return response()->json(['success'=>true,'data'=>$attemptData]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }

    public function approvedQna(Request $request){
        try {
            $attemptId = $request->attempt_id;

            $examData = ExamAttempt::where('id',$attemptId)->with('exam')->get();
            $marks = $examData[0]['exam']['marks'];

            $attemptData = ExamAnswer::where('attempt_id',$attemptId)->with('answers')->get();
            $totalMarks = 0;

            if (count($attemptData) > 0) {
                foreach ($attemptData as $attempt) {
                    if ($attempt->answers->is_correct == 1) {
                        $totalMarks += $marks;
                    }
                }
            }

            ExamAttempt::where('id',$attemptId)->update([
                'status' => 1,
                'marks' =>$totalMarks
            ]);
            $url = URL::to('/');

            $data['url'] = $url.'/results';
            $data['name'] = $examData[0]['user']['name'];
            $data['email'] = $examData[0]['user']['email'];
            $data['exam_name'] = $examData[0]['exam']['exam_name'];
            $data['title'] = $examData[0]['exam']['exam_name'].'Result';

            Mail::send('result-mail',['data' => $data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['success'=>true,'msg'=>'Approved successfully!',]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>'Echec : '.$e->getMessage()]);
        }
    }
}
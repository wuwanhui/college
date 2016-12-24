<?php

namespace App\Mail;

use App\Models\Syllabus;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SyllabusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $syllabus;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Syllabus $syllabus)
    {
        $this->syllabus = $syllabus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $student = $this->syllabus->studentRelate->student;
        $agenda = $this->syllabus->agendaRelate->agenda;
        $state = $this->syllabus->state == 0 ? '通过' : '拒绝';
        if (isset($student->email)) {
            return $this->to($student->email, $student->name)->subject($agenda->name . ' - 课程通知')->view('emails.syllabus')->with([
                'name' => $student->name,
                'agenda' => $agenda->name,
                'state' => $state,
            ]);
        }
    }


}

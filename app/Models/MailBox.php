<?php

namespace App\Models;

use App\Mail\SendApplication;
use App\Mail\SendContact;
use App\Mail\SendForgotPassword;
use App\Mail\SendRegister;
use Illuminate\Database\Eloquent\Model;

class MailBox extends Model
{
    protected $fillable = [
        'id',
        'object_id',
        'email_from',
        'name_from',
        'email_to',
        'name_to',
        'subject',
        'content',
        'file',
        'type',
        'send_date',
        'priority',
        'status',
        'email_cc',
        'email_bcc',
        'count_sent_error',
    ];

    const _LIMIT    = 25;
    const _READ     = 1;
    const _UNREAD   = null;

    const _max_sent_error = 2;
    const _system_name = 'STAVIAN';

    const _TYPE_APPLICATION_INFORM = 'application_inform';
    const _TYPE_APPLICATION = 'application';
    const _TYPE_CONTACT = 'contact';

    const _PRIORITY_URGENT  = 1;
    const _PRIORITY_HIGH    = 2;
    const _PRIORITY_NORMAL  = 3;
    const _PRIORITY_LOW     = 4;

    const _MAIL_SUBJECT = [
        self::_TYPE_APPLICATION_INFORM => '['. self::_system_name .'] Apply for ',
        self::_TYPE_APPLICATION => '['. self::_system_name .'] Apply for ',
        self::_TYPE_CONTACT => '['. self::_system_name .'] Contact ',
    ];

    const _MAIL_TEAMPLATE = [
        self::_TYPE_APPLICATION_INFORM => 'emails.'. self::_TYPE_APPLICATION_INFORM,
        self::_TYPE_APPLICATION => 'emails.'. self::_TYPE_APPLICATION,
        self::_TYPE_CONTACT => 'emails.'. self::_TYPE_CONTACT,
    ];

    public function setContentAttribute($data){
        $this->attributes['content'] = json_encode($data);
    }

    public function getContentAttribute(){
        return json_decode($this->attributes['content'],true);
    }

    public static function doCreate(array $params, $send_to = 'system')
    {
        if (empty($params))
            return null;

        $setting_email = optional(Datameta::getData(['type' => Datameta::TYPE_SETTING, 'field' => 'email']))->data_value;

        if ($send_to == 'system') {
            $email_from = isset($params['email']) ? $params['email'] : null;
            $name_from = isset($params['name']) ? $params['name'] : null;
            $email_to = isset($params['email_to_system']) ? $params['email_to_system'] : $setting_email;
            $name_to = self::_system_name;
        } else {
            $email_from = $setting_email;
            $name_from = self::_system_name;
            $email_to = isset($params['email']) ? $params['email'] : null;
            $name_to = isset($params['name']) ? $params['name'] : null;
        }

        $attributes = [
            'object_id'     => isset($params['object_id']) ? $params['object_id'] : null,
            'subject'       => isset($params['subject']) ? $params['subject'] : null,
            'content'       => isset($params['content']) ? $params['content'] : null,
            'file'          => isset($params['file']) ? $params['file'] : null,
            'type'          => isset($params['type']) ? $params['type'] : null,
            'send_date'     => isset($params['send_date']) ? $params['send_date'] : null,
            'priority'      => isset($params['priority']) ? $params['priority'] : self::_PRIORITY_NORMAL,
            'email_from'    => $email_from,
            'name_from'     => $name_from,
            'email_to'      => $email_to,
            'name_to'       => $name_to,
        ];

        $data = self::query()->create($attributes);
        return $data->id;
    }

    public function sentMail()
    {
        $mail = null;
        $date = date("Y-m-d H:i:s");

        $mail_to_send = [];
        $mail_to = explode(",", $this->email_to);

        foreach($mail_to as $item){
            $format_mail = !empty($item) ? trim($item) : null;
            if (!empty($format_mail))
                $mail_to_send[] = $format_mail;
        }

        if (!empty($mail_to_send)) {
            $template = self::_MAIL_TEAMPLATE[$this->type];

            $mail = \Mail::send($template, $this->content , function ($mail) use ($mail_to_send) {

                $mail->from(env('MAIL_USERNAME'), $this->name_from);
                $mail->to($mail_to_send);
                $mail->subject($this->subject);

                if(isset($this->email_cc) && !empty($this->email_cc))
                    $mail->cc($this->email_cc);

                if(isset($this->email_bcc) && !empty($this->email_bcc))
                    $mail->bcc($this->email_bcc);

                if(isset($this->file) && !empty( $this->file ) && file_exists(public_path($this->file)) && $this->type != self::_TYPE_APPLICATION_INFORM) {
                    $mail->attach(public_path($this->file));
                }
            });
        }

        $this->send_date = $date;
        if(empty($this->count_sent_error))
            $this->count_sent_error = 0;

        if (!$mail)
            $this->status = Constant::STATUS_ACTIVE;
        else
            $this->count_sent_error += 1;

        $this->save();

        return $mail;
    }
}

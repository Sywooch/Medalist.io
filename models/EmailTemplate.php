<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email_template".
 *
 * @property integer $email_template_id
 * @property string $code
 * @property string $email_from
 * @property string $name_from
 * @property string $email_to
 * @property string $cc
 * @property string $bcc
 * @property string $html
 * @property string $text
 * @property string $extra_headers
 * @property string $files
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    const ALARM_NOTIFICATION = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['html', 'text', 'extra_headers', 'files'], 'string'],
            [['code'], 'string', 'max' => 255],
            [['email_from', 'name_from', 'email_to', 'cc', 'bcc'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email_template_id' => 'Email Template ID',
            'code' => 'Code',
            'email_from' => 'Email From',
            'name_from' => 'Name From',
            'email_to' => 'Email To',
            'cc' => 'Cc',
            'bcc' => 'Bcc',
            'html' => 'Html',
            'text' => 'Text',
            'extra_headers' => 'Extra Headers',
            'files' => 'Files',
        ];
    }

    /**
     * @inheritdoc
     * @return EmailTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmailTemplateQuery(get_called_class());
    }


    public function send( $to, $subject, $fields, $from = false, $cc = false, $bcc = false ){

        $template = $this->html;
        $templateText = $this->text;

        if( empty($from) ){
            $from = $this->email_from;
        }


        foreach ($fields as $field => $value) {
            $template = str_replace("#".$field."#", $value, $template);
            $templateText = str_replace("#".$field."#", $value, $templateText);
        }

        //SENDING 

        $mailer = Yii::$app->mailer->compose()
            ->setFrom( $from )
            ->setTo( $to )
            ->setSubject( $subject )
            ->setTextBody( $templateText )
            ->setHtmlBody( $template);
           
        if( !empty($bcc) )   {
            $mailer->setBcc( $bcc );
        }  
        if( !empty($cc) )   {
            $mailer->setCc( $cc );
        }
        $mailer->send();



    }
}

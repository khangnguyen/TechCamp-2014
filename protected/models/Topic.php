<?php

/**
 * This is the model class for table "topics".
 *
 * The followings are the available columns in table 'topics':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $slide_url
 * @property string $speaker_name
 * @property string $speaker_description
 * @property string $speaker_url
 * @property string $created_at
 * @property string $updated_at
 */
class Topic extends CActiveRecord
{
    public $vote_id;
    public $vote_count;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Topic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'topics';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, speaker_name, speaker_email, speaker_phoneno', 'required'),
			array('title, speaker_name', 'length', 'max'=>128),
			array('speaker_email', 'email'),			
			array('duration', 'numerical', 'integerOnly'=>true),
			array('category, language, desired_time, slide_url, speaker_description, speaker_url, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, slide_url, speaker_name, speaker_description, speaker_url, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

        protected function beforeValidate() {
            $this->updated_at = date('Y-m-d H:i:s');
	    $this->slide_url = $this->addhttp($this->slide_url);
	    $this->speaker_url = $this->addhttp($this->speaker_url);
            return True;
        }

	private function addhttp($url) {
	    if ($url != '' && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'votes' => array(self::HAS_MANY, 'Vote', 'topic_id'),
			'voteCount' => array(self::STAT, 'Vote', 'topic_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'title' => 'Title',
			'description' => 'Description',
			'slide_url' => 'Slide Url',
			'speaker_name' => 'Speaker Name',
			'speaker_email' => 'Speaker Email',
			'speaker_phoneno' => 'Speaker Phone No.',
			'speaker_description' => 'Speaker Description',
			'speaker_url' => 'Speaker Url',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'desired_time' => 'Desired time for presentation'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($userId, $updated_at='1990-01-01 01:01:01')
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $sort = new CSort();
		$sort->defaultOrder = 'created_at DESC';
                $sort->attributes = array(
                    'id'=>array(
                        'asc'=>'vote_count ASC',
                        'desc'=>'vote_count DESC',
                    ),
                    'speaker_name'=>array(
                        'asc'=>'speaker_name ASC',
                        'desc'=>'speaker_name DESC',
                    ),
                    'title'=>array(
                        'asc'=>'title ASC',
                        'desc'=>'title DESC',
                    ),
                );

                $criteria->join = "LEFT JOIN votes v1 ON v1.topic_id=t.id LEFT JOIN votes v2 ON v2.topic_id = t.id AND v2.id = '" . $userId . "'";
                $criteria->select = 't.*, COUNT(v1.id) vote_count, v2.id vote_id';
                $criteria->group = 't.id, v2.id';

		$criteria->compare('LOWER(title)',strtolower($this->title), true, 'OR', true);
		$criteria->compare('LOWER(description)',strtolower($this->title), true, 'OR', true);
		$criteria->compare('LOWER(language)',strtolower($this->title), true, 'OR', true);

		$criteria->compare('LOWER(speaker_name)',strtolower($this->speaker_name), true, 'OR', true);
		$criteria->compare('LOWER(speaker_description)',strtolower($this->speaker_name), true, 'OR', true);

                $criteria->compare('updated_at', " > " . $updated_at, true);

		return new CActiveDataProvider('Topic', array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
			'pagination'=>array('pageSize'=>50,),
		));
	}
}
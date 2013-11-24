<?php

/**
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
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
class Post extends CActiveRecord
{
    public $vote_id;
    public $vote_count;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Post the static model class
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
		return 'posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, speaker_name', 'required'),
			array('title, speaker_name', 'length', 'max'=>128),
			array('slide_url, speaker_description, speaker_url, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, slide_url, speaker_name, speaker_description, speaker_url, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

        protected function beforeValidate() {
            $this->updated_at = date('Y-m-d H:i:s');
            return True;
        }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'votes' => array(self::HAS_MANY, 'Vote', 'post_id'),
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
			'speaker_description' => 'Speaker Description',
			'speaker_url' => 'Speaker Url',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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

                $criteria->join = "LEFT JOIN votes v1 ON v1.post_id=t.id LEFT JOIN votes v2 ON v2.post_id = t.id AND v2.id = '" . $userId . "'";
                $criteria->select = 't.*, COUNT(v1.id) vote_count, v2.id vote_id';
                $criteria->group = 't.id, v2.id';

		$criteria->compare('title',$this->title,true);
		$criteria->compare('speaker_name',$this->speaker_name,true);

                $criteria->compare('updated_at', " > " . $updated_at, true);

		return new CActiveDataProvider('Post', array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
		));
	}
}
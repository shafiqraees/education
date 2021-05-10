<?php

namespace App\Traits;

use App\Models\Appointment;
use App\Models\Faq;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;
use DateTime;
use PhpParser\Node\Expr\Cast\Double;
use Ramsey\Uuid\Type\Integer;
use Illuminate\Support\Arr;

trait Transformer
{
    //transform Collection
    public static function transformCollection($collection)
    {
        $params = http_build_query(request()->except('page'));
        $next = $collection->nextPageUrl();
        $previous = $collection->previousPageUrl();
        $current = $collection->currentPage();
        if ($params) {
            if ($next) {
                $next .= "&{$params}";
            }
            if ($previous) {
                $previous .= "&{$params}";
            }
        }
        $meta = [
            "next" => (string)$next,
            "previous" => (string)$previous,
            "per_page" => (integer)$collection->perPage(),
            "current_page" => (integer)$current,
            "total" => (integer)$collection->total()
        ];
        return $meta;
    }

// transform Followers, Following and Posts counts
    public static function transformOption($collection)
    {
        $data = [];
        $data['id'] = (int)$collection->id;
        $data['name'] = $collection->name;
        $data['questio_code'] = (int)$collection->iquestio_coded;
        $data['type'] = (string)$collection->type ? $collection->type : '';
        $data['image'] = (string)$collection->image ? Storage::disk('public')->url('lg/'.$collection->image) : url('lg/'.Storage::disk('public')->url('default.png'));

        if (!empty($collection->option)) {
            $temp_record = [];
            foreach ($collection->option as $category) {
                $temp_image = [
                    'id' => (int)$category->id,
                    'suggested_question_id' => (int)$category->suggested_question_id,
                    'name' => (string)$category->name,
                    'answer' => (string)$category->answer,
                    'image' => (string)$category->image ? Storage::disk('public')->url('xs/'.$category->image) : url(Storage::disk('public')->url('default.png')),
                ];
                array_push($temp_record, $temp_image);
            }
            $data['question_options'] = $temp_record;
        }
        return $data;
    }

    // transform Buisness Profile
    public static function transformViewBuisnessProfile($post_data,$type)
    {
        $transformed_data = [];
        if (!empty($post_data)) {
            foreach ($post_data as $data) {
                $temp = [
                    'id' => $data->id,
                    'title' => (string)!empty($data->title) ? $data->title : "",
                    'description' => (string)$data->description,
                    'is_featured' => (string)$data->is_featured,
                    //'doctor_image' => Storage::disk('s3')->exists($doctor->profile_image) ? Storage::disk('s3')->url($doctor->profile_image) : url(Storage::url('files/no-image.png')),
                ];
                if (!empty($data->postImage)) {
                    $temp_record = [];
                    foreach ($data->postImage as $images) {
                        if (isset($type) && $type == "video") {
                            $image_path = Storage::disk('s3')->exists('lg/'.$images->video_thumbnail) ? Storage::disk('s3')->url('lg/'.$images->video_thumbnail) : url(Storage::disk('s3')->url('default.png'));
                        } else {
                            $image_path = Storage::disk('s3')->exists('lg/'.$images->image) ? Storage::disk('s3')->url('lg/'.$images->image) : url(Storage::disk('s3')->url('default.png'));
                        }
                        $temp_image = [
                            'image_id' => (int)$images->id,
                            'image' => !empty($image_path) ? $image_path : url(Storage::disk('s3')->url('default.png')),
                            'video' => $images->video,
                            'created_at' => $data->created_at->diffForHumans(),
                            //'doctor_image' => Storage::disk('s3')->exists($doctor->profile_image) ? Storage::disk('s3')->url($doctor->profile_image) : url(Storage::url('files/no-image.png')),
                        ];
                        array_push($temp_record, $temp_image);
                    }
                    $temp['images'] = $temp_record;
                }
                if (!empty($data->postTopics)) {
                    $temp_topics = [];
                    foreach ($data->postTopics as $topic) {
                        $temp_topic_array = [
                            'topic_id' => (int)$topic->topic_id,
                            'post_id' => (int)$topic->post_id
                        ];
                        array_push($temp_topics, $temp_topic_array);
                    }
                    $temp['postTopics'] = $temp_topics;
                }
                array_push($transformed_data, $temp);
            }
        }
        return $transformed_data;
    }

    // transform Buisness Profile
    public static function transformProfileDetail($data)
    {
        $temp = [];
        if (!empty($data)) {
                $temp = [
                    'id' => (int)$data->id,
                    'user_id' => (int)$data->user_id,
                    'profile_name' => !empty($data->profile_name) ? (string)$data->profile_name : "",
                    'profile_email' => (string)$data->profile_email,
                    'profile_phone' => (string)$data->profile_phone,
                    'profile_address' => (string)$data->profile_address,
                    'profile_website' => (string)$data->profile_website,
                    'profile_about' => (string)$data->profile_about,
                    'firbase_token' => (string)$data->firbase_token,
                    'profile_type' => (string)$data->profile_type,
                    'profile_status' => (string)$data->profile_status,
                    'notification_status' => (string)$data->notification_status,
                    'created_at' => (string)$data->created_at,
                    'city_id' => (int)$data->city_id,
                    'city_name' => (string)$data->city->name,
                    'country_id' => (int)$data->country_id,
                    'country_name' => (string)$data->country->name,
                    'profile_image' => Storage::disk('s3')->exists('lg/'.$data->profile_image) ? Storage::disk('s3')->url('lg/'.$data->profile_image) : Storage::disk('s3')->url('default.png'),
                ];
                if (!empty($data->userCategories)) {
                    $temp_record = [];
                    foreach ($data->userCategories as $category) {
                        $temp_image = [
                            'category_id' => (int)$category->id,
                            'category_name' => (int)$category->name,
                        ];
                        array_push($temp_record, $temp_image);
                    }
                    $temp['category'] = $temp_record;
                }
        }
        return $temp;
    }

    // transform Buisness Profile
    public static function transformQuestionDetail($data)
    {
        $temp = [];
        if (!empty($data)) {
            $temp = [
                'id' => (int)$data->id,
                'serial_id' => (int)$data->user_id,
                'question_paper_id' => (int)$data->user_id,
                'questio_code' => !empty($data->questio_code) ? (string)$data->questio_code : "",
                'name' => (string)$data->name,
                'final_question' => (string)$data->final_question,
                ];
            if (!empty($data->option)) {
                $temp_record = [];
                foreach ($data->option as $category) {
                    $temp_image = [
                        'option_id' => (int)$category->id,
                        'option_name' => (string)$category->name,
                        'suggested_question_id' => (int)$category->suggested_question_id,
                        'answer' => (string)$category->answer,
                        'Feedback' => (string)$category->Feedback,
                    ];
                    array_push($temp_record, $temp_image);
                }
                $temp['option'] = $temp_record;
            }
        }
        return $temp;
    }

    // transform All friends
    public static function transformAllFriends($followers,$following, $keyword)
    {
        $transformed_data = [];
        if (!empty($followers) && !empty($following)) {
            $result = array_intersect($followers, $following);
            $transformed_data = Self::getFriends($result, $keyword);
        }

        return $transformed_data;
    }

    static function getFriends($friendsIds,$keyword)
    {
        $records = [];
        if (!empty($friendsIds)) {
            $query = UserProfile::select('id as profile_id','user_id','profile_name','profile_email','profile_image','profile_type',
                'profile_status','created_at','firbase_token')
                ->whereProfileIsSuspend('false');
            if (isset($keyword) && !empty($keyword)) {
                $query = $query->where('profile_name','LIKE','%'.$keyword.'%');
            }
            $query = $query->whereIn('id', $friendsIds);
            $friends_data = $query->get();
            if ($friends_data) {
                $result = [];
                foreach ($friends_data as $data) {
                    $temp = [
                        'profile_id' => $data->profile_id,
                        'user_id' => $data->user_id,
                        'profile_name' => $data->profile_name,
                        'profile_email' => $data->profile_email,
                        'profile_image' => Storage::disk('s3')->exists('lg/'.$data->profile_image) ? Storage::disk('s3')->url('lg/'.$data->profile_image) : Storage::disk('s3')->url('default.png'),
                        'profile_type' => $data->profile_type,
                        'profile_status' => $data->profile_status,
                        'created_at' => $data->created_at,
                        'firbase_token' => $data->firbase_token,
                    ];
                    array_push($result, $temp);
                }
                $records = $result;
            }
        }
        return $records;
    }

    // transform Buisness Profile
    public static function transformSuggestedFriends($user_categories,$id)
    {
        $transformed_data = [];
        $arrayunique = [];
        $string = "";
        if (!empty($user_categories)) {
            foreach ($user_categories as $category) {
                if (!empty($category->userProfiles)){
                    foreach ($category->userProfiles as $data) {
                        if ($data->id == $id){
                            continue;
                        }
                        $temp = [
                            'profile_id' => $data->id,
                            'user_id' => $data->user_id,
                            'profile_name' => $data->profile_name,
                            'profile_email' => $data->profile_email,
                            'profile_image' => Storage::disk('s3')->exists('lg/'.$data->profile_image) ? Storage::disk('s3')->url('lg/'.$data->profile_image) : Storage::disk('s3')->url('default.png'),
                            'profile_type' => $data->profile_type,
                            'profile_status' => $data->profile_status,
                            'created_at' => date('Y-m-d H:i', strtotime($data->created_at)),
                            'profile_is_suspend' => $data->profile_is_suspend,
                        ];
                        array_push($arrayunique, $temp);
                    }
                }

            }
        }
        if (!empty($arrayunique)) {
            $transformed_data =  array_values(array_unique($arrayunique, SORT_REGULAR));
        }
        return $transformed_data;
    }

    // transform posts
    public static function transformPosts($collection,$type)
    {
        $transformed_data = [];
        if (!empty($collection)) {
            foreach ($collection as $data) {
                $temp = [
                    'post_id' => $data->id,
                    'title' => $data->title,
                    'description' => $data->description,
//                    'image' => Storage::disk('s3')->exists($data->profile_image) ? Storage::url($data->profile_image) : Storage::url('default.png'),
                    'is_featured' => $data->is_featured,
                    'created_at' => !empty($data->created_at) ? $data->created_at->diffForHumans() : null,
                    'post_comments_count' => $data->post_comments_count,
                    'is_share_count' => $data->is_share_count,
                    'is_like_count' => $data->is_like_count,
                    'is_self_like' => $data->self_like == "0" ? "false" : "true",
                ];
                if (isset($data->postImage)){
                    $image_array = [];
                    foreach ($data->postImage as $image) {

                        if ((isset($type) && $type == "video") || !empty($image->video_thumbnail)) {
                            $image_path = Storage::disk('s3')->exists('lg/'.$image->video_thumbnail) ? Storage::disk('s3')->url('lg/'. $image->video_thumbnail) : url(Storage::disk('s3')->url('default.png'));
                        } else {
                            $image_path = Storage::disk('s3')->exists('lg/'.$image->image) ? Storage::disk('s3')->url('lg/'.$image->image) : url(Storage::disk('s3')->url('default.png'));
                        }
                        $temp_image = [
                            'image_id' => $image->id,
                            'image' => !empty($image_path) ? $image_path : url(Storage::disk('s3')->url('default.png')),
                            'video' => isset($image->video) ? $image->video : "",
                        ];
                        array_push($image_array, $temp_image);
                    }
                    $temp['images'] = $image_array;
                }
                if (isset($data->hashtag)){
                    $hash_tag_array = [];
                    $string = "";
                    foreach ($data->hashtag as $hastag) {
                        $string .= '#'.$hastag->name.', ';
                    }

                    $temp['hash_tag'] = $string;

                }
                if (isset($data->postCategories)){
                    $category_array = [];
                    foreach ($data->postCategories as $category) {
                        $temp_category = [
                            'category_id' => $category->id,
                            'name' => $category->name,
                            'status' => $category->status
                        ];
                        array_push($category_array, $temp_category);
                    }
                    $temp['category'] = $category_array;
                }
                if (isset($data->userProfile)){
                    $temp_profile = [
                        'profile_id' => $data->userProfile->id,
                        'profile_name' => $data->userProfile->profile_name,
                        'profile_image' => Storage::disk('s3')->exists('lg/'.$data->userProfile->profile_image) ? Storage::disk('s3')->url('lg/'.$data->userProfile->profile_image) : Storage::disk('s3')->url('default.png'),
                    ];
                    $temp['user_profile'] = $temp_profile;
                }
                array_push($transformed_data, $temp);
            }

        }

        return $transformed_data;
    }

    // transform post detail
    public static function transformPostDetail($data)
    {
        $transformed_data = [];
        if (!empty($data)) {
            $temp = [
                'post_id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
//                    'image' => Storage::disk('s3')->exists($data->profile_image) ? Storage::url($data->profile_image) : Storage::url('default.png'),
                'is_featured' => $data->is_featured,
                'created_at' => !empty($data->created_at) ? $data->created_at->diffForHumans() : null,
                'post_comments_count' => $data->post_comments_count,
                'is_share_count' => $data->is_share_count,
                'is_like_count' => $data->is_like_count,
                'is_self_like' => $data->self_like == "0" ? "false" : "true",
                'profile_id' => $data->userProfile->id,
                'profile_name' => $data->userProfile->profile_name,
                'profile_image' => Storage::disk('s3')->exists('lg/'.$data->userProfile->profile_image) ? Storage::disk('s3')->url('lg/'.$data->userProfile->profile_image) : Storage::disk('s3')->url('default.png'),
            ];
            if (isset($data->postImage)){
                $image_array = [];
                foreach ($data->postImage as $image) {
                    if (!empty($image->video_thumbnail)) {
                       $image_path =  Storage::disk('s3')->exists('lg/'.$image->video_thumbnail) ? Storage::disk('s3')->url('lg/'.$image->video_thumbnail) : Storage::disk('s3')->url('default.png');
                    } else {
                        $image_path =  Storage::disk('s3')->exists('lg/'.$image->image) ? Storage::disk('s3')->url('lg/'.$image->image) : Storage::disk('s3')->url('default.png');
                    }
                    $temp_image = [
                        'image_id' => $image->id,
                        'image' => !empty($image_path) ? $image_path : Storage::disk('s3')->url('default.png'),
                        'video' => $image->video,
                    ];
                    array_push($image_array, $temp_image);
                }
                $temp['images'] = $image_array;
            }
            if (isset($data->hashtag)){
                $hash_tag_array = [];
                foreach ($data->hashtag as $hastag) {
                    $temp_hash_tag = [
                        'hash_tag_id' => $hastag->id,
                        'name' => $hastag->name,
                        'status' => $hastag->status
                    ];
                    array_push($hash_tag_array, $temp_hash_tag);
                }
                $temp['hash_tag'] = $hash_tag_array;
            }
            if (isset($data->postCategories)){
                $category_array = [];
                foreach ($data->postCategories as $category) {
                    $temp_category = [
                        'hash_tag_id' => $category->id,
                        'name' => $category->name,
                        'status' => $category->status
                    ];
                    array_push($category_array, $temp_category);
                }
                $temp['category'] = $category_array;
            }
            if (isset($data->getpostTopic)){
                $topic_array = [];
                foreach ($data->getpostTopic as $topic) {
                    $temp_topic = [
                        'topic_id' => $topic->id,
                        'name' => $topic->name,
                        'status' => $topic->status
                    ];
                    array_push($topic_array, $temp_topic);
                }
                $temp['topics'] = $topic_array;
            }
            if (isset($data->postComments)){
                $coment_array = [];
                foreach ($data->postComments as $comment) {
                    $temp_comment = [
                        'comment_id' => $comment->id,
                        'comment' => $comment->comment,
                        'status' => $comment->status,
                        'comment_created_at' => $comment->created_at,
                        'comment_likes_count' => $comment->comment_likes_count,
                        'self_comment_like' => $comment->self_comment_like == "0" ? "false" : "true",
                        'comment_by_profile_id' => isset($comment->userProfile->id) ? $comment->userProfile->id : null,
                        'comment_by_profile_name' => isset($comment->userProfile->profile_name) ? $comment->userProfile->profile_name : null,
                        'comment_by_profile_image' => Storage::disk('s3')->exists('xs/'.$comment->userProfile->profile_image) ? Storage::disk('s3')->url('xs/'.$comment->userProfile->profile_image) : Storage::disk('s3')->url('default.png'),
                    ];
                    array_push($coment_array, $temp_comment);
                }
                $temp['comments'] = $coment_array;
            }
            $transformed_data = $temp;

        }

        return $transformed_data;
    }

    // transform post detail
    public static function transformSideBar($collection)
    {
        $transformed_data = [];
        if (!empty($collection)) {
            $temp_data = [];
            foreach ($collection as $data) {
                $temp = [
                    'sidebar_id' => $data->id,
                    'sidebar_name' => $data->name,
                    'created_at' =>  $data->created_at->diffForHumans()
                ];
                if (isset($data->CmsTypes)){
                    $temp['content'] = $data->CmsTypes->content;
                }

                if (isset($data->CmsTypes->CmsTypeImages)){
                    $user_array = [];
                    $buisness_array = [];
                    foreach ($data->CmsTypes->CmsTypeImages as $image) {
                        if ($image->toturial_type == "user"){
                            $temp_user = [
                                'image_id' => $image->id,
                                'name' => $image->name,
                                'toturial_type' => $image->toturial_type,
                                'image' => Storage::disk('s3')->exists('lg/'.$image->image) ? Storage::disk('s3')->url('lg/'.$image->image) : $image->image,
                            ];
                            array_push($user_array, $temp_user);
                        } elseif ($image->toturial_type == "buisness") {
                            $temp_buisness = [
                                'image_id' => $image->id,
                                'name' => $image->name,
                                'toturial_type' => $image->toturial_type,
                                'image' => Storage::disk('s3')->exists('lg/'.$image->image) ? Storage::disk('s3')->url('lg/'.$image->image) : $image->image,
                            ];
                            array_push($buisness_array, $temp_buisness);
                        }
                    }
                    $temp['about_us_user'] = $user_array;
                    $temp['about_us_buisness'] = $buisness_array;
                }
                array_push($temp_data, $temp);
            }
            $transformed_data['side_bar'] = $temp_data;
        }

        return $transformed_data;
    }

    // transform post detail
    public static function transformAdds($collection,$profile)
    {
        //dd($collection);
        $transformed_data = [];
        if (!empty($collection)) {
            foreach ($collection as $data) {

                if (($data->userProfile->credits <= $data->totalcount)) {
                    continue;
                }
                if ($data->impressions <= $data->add_impressions_count){
                    continue;
                }
                    $temp = [
                        'add_id' => $data->id,
                        'name' => $data->name,
                        'description' => $data->description,
                        'add_date' => $data->add_date,
                        'end_date' => $data->end_date,
                        'status' => $data->status,
                        'banner' => Storage::disk('s3')->exists('lg/'.$data->banner) ? Storage::disk('s3')->url('lg/'.$data->banner) : Storage::disk('s3')->url('default.png'),
                        'video' => $data->video,
                        'created_at' => !empty($data->created_at) ? $data->created_at->diffForHumans() : null,
                        'add_impressions_count' => $data->add_impressions_count,
                        'add_activities_count' => $data->add_activities_count,
                        'is_share_count' => $data->is_like_count,
                        'is_like_count' => $data->is_like_count,
                        'is_self_like' => $data->self_like == "0" ? "false" : "true",
                    ];
                    /*if (isset($data->hashtag)){
                        $hash_tag_array = [];
                        foreach ($data->hashtag as $hastag) {
                            $temp_hash_tag = [
                                'hash_tag_id' => $hastag->id,
                                'name' => $hastag->name,
                                'status' => $hastag->status
                            ];
                            array_push($hash_tag_array, $temp_hash_tag);
                        }
                        $temp['hash_tag'] = $hash_tag_array;
                    }*/
                    if (isset($data->userProfile)){
                        $temp_profile = [
                            'profile_id' => $data->userProfile->id,
                            'profile_name' => $data->userProfile->profile_name,
                            'profile_image' => Storage::disk('s3')->exists('lg/'.$data->userProfile->profile_image) ? Storage::disk('s3')->url('lg/'.$data->userProfile->profile_image) : Storage::disk('s3')->url('default.png'),
                        ];
                        $temp['user_profile'] = $temp_profile;
                    }
                    array_push($transformed_data, $temp);
            }

        }

        return $transformed_data;
    }

    // transform user
    public static function transformCreatePost($collection)
    {

        $transformed_post = [
            'id' => (int)$collection->id,
            'user_id' => (int)$collection->user_id,
            'user_profile_id' => (int)$collection->user_profile_id,
            'title' => (string)$collection->title,
            'description' => (string)$collection->description,
            'updated_at' => (string)$collection->updated_at,
            'created_at' => (string)$collection->created_at,
        ];
        return $transformed_post;
    }

    // transform Audience
    public static function transformAudience($collection,$age_from,$age_to)
    {
        $transformed_data = [];
        $str = 0;
        if ($collection) {
            foreach ($collection as $data) {
                $age = \Carbon\Carbon::parse($data->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y');
                if (($age >= $age_from) && $age <= $age_to) {
                    $temp = [
                        'id' => $data->id,
                    ];
                    array_push($transformed_data, $temp);
                }

            }

        }
        $str = count($transformed_data);
        return $str;
    }

    public static function transformSuspendUser($user)
    {

        $transformed_user = [
            'id' => (int)$user->id,
            'is_active' => (string)$user->is_active,
        ];

        return $transformed_user;
    }

    // transform user
    public static function transformPushNotification($collection)
    {

        $transformed_data = [];
        if (!empty($collection)) {
            foreach ($collection as $data) {
                $temp = [
                    'id' => $data->id,
                    'title' => $data->pushNotification->titile,
                    'message' => $data->pushNotification->message,
                    'status' => $data->status,
                    'created_at' => $data->created_at,
                ];
                array_push($transformed_data, $temp);
            }

        }
        return $transformed_data;
    }

    // transform user
    public static function transformfollowers($collection)
    {

        $transformed_data = [];
        if (!empty($collection)) {
            foreach ($collection as $data) {
                $temp = [
                    'id' => $data->id,
                    'profile_name' => $data->profile_name,
                    'profile_email' => $data->profile_email,
                    'profile_phone' => $data->profile_phone,
                    'profile_address' => $data->profile_address,
                    'profile_website' => $data->profile_address,
                    'profile_type' => $data->profile_type,
                    'profile_status' => $data->profile_status,
                    'profile_is_suspend' => $data->profile_is_suspend,
                    'created_at' => $data->created_at,
                    'profile_image' => (string)Storage::disk('s3')->exists('lg/'.$data->profile_image) ? Storage::disk('s3')->url('lg/'.$data->profile_image) : Storage::disk('s3')->url('default.png'),
                ];
                array_push($transformed_data, $temp);
            }

        }
        return $transformed_data;
    }

    // transform Buisness Profile
    public static function transformCatPosts($post_data)
    {
        $transformed_data = [];
        if (!empty($post_data)) {
            foreach ($post_data as $data) {
                $temp = [
                    'id' => $data->id,
                    'title' => (string)!empty($data->title) ? $data->title : "",
                    'description' => (string)$data->description,
                    'is_featured' => (string)$data->is_featured,
                    'profile_id' => $data->userProfile->id,
                    'profile_name' => $data->userProfile->profile_name,
                    'profile_image' => Storage::disk('s3')->exists('xs/'.$data->userProfile->profile_image) ? Storage::disk('s3')->url('xs/'.$data->userProfile->profile_image) : Storage::disk('s3')->url('default.png'),
                ];
                if (!empty($data->postImage)) {
                    $temp_record = [];
                    foreach ($data->postImage as $images) {
                        $temp_image = [
                            'image_id' => (int)$images->id,
                            'image' => Storage::disk('s3')->exists('lg/'.$images->image) ? Storage::disk('s3')->url('lg/'.$images->image) : Storage::disk('s3')->url('default.png'),
                            'video' => $images->video,
                            'created_at' => $data->created_at->diffForHumans(),
                            //'doctor_image' => Storage::disk('s3')->exists($doctor->profile_image) ? Storage::disk('s3')->url($doctor->profile_image) : url(Storage::url('files/no-image.png')),
                        ];
                        array_push($temp_record, $temp_image);
                    }
                    $temp['images'] = $temp_record;
                }
                array_push($transformed_data, $temp);
            }
        }
        return $transformed_data;
    }
    public static function transformRequestedfollowers($collection)
    {

        $transformed_data = [];
        if (!empty($collection)) {
            foreach ($collection as $data) {
                $temp = [
                    'id' => $data->id,
                    'profile_name' => $data->profile_name,
                    'profile_email' => $data->profile_email,
                    'profile_phone' => $data->profile_phone,
                    'profile_address' => $data->profile_address,
                    'profile_website' => $data->profile_address,
                    'profile_type' => $data->profile_type,
                    'profile_status' => $data->profile_status,
                    'profile_is_suspend' => $data->profile_is_suspend,
                    'created_at' => $data->created_at,
                    'profile_image' => (string)Storage::disk('s3')->exists('lg/'.$data->profile_image) ? Storage::disk('s3')->url('lg/'.$data->profile_image) : Storage::disk('s3')->url('default.png'),
                ];
                array_push($transformed_data, $temp);
            }

        }
        return $transformed_data;
    }

    // method return Vimeo thumnail images
}

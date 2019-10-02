<?php

namespace App\Observers;

use App\Models\HdrsVideo;

class HdrsVideoObserver
{
	/**
	 * 监听用户创建的事件。
	 *
	 * @param  HdrsVideo  $video
	 * @return void
	 */
	public function creating(HdrsVideo $video)
	{
	    if (empty($video->group_id))
        {
            $video->group_id = 0;
        }
//		$video->video_url = urlencode($video->video_url);
		//
	}


	/**
	 * 监听用户删除事件。
	 *
	 * @param  HdrsVideo  $video
	 * @return void
	 */
	public function deleting(HdrsVideo $video)
	{
		//
	}

	public function updating(HdrsVideo $video)
	{
        if (empty($video->group_id))
        {
            $video->group_id = 0;
        }

	}
}
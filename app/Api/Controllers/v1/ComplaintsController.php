<?php
namespace App\Api\Controllers\v1;


use App\Api\Controllers\ApiControllers;
use App\Models\HdrsComplaints;
use Illuminate\Http\Request;

class ComplaintsController extends ApiControllers
{

	/**
	 *
	 * title,content
	 * @param Request $request
	 * @return mixed
	 */
	public function add(Request $request)
	{
		$this->validate($request, [
			'title' => 'required|max:255',
			'content' => 'required|max:500',
			'mobile' => 'required|numeric|digits_between:10,13'
		]);
		$status = HdrsComplaints::create([
			'title' => $request['title'],
			'content' => $request['content'],
			'mobile' => $request['mobile'],
			'user_id' => auth()->user()->id,
										 ]);
		if ($status) {
			return $this->success(['message' => '创建成功']);
		}
		return $this->failed('创建失败');
	}
}
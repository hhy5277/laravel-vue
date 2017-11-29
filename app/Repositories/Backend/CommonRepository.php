<?php
namespace App\Repositories\Backend;

use App\Repositories\Common\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommonRepository extends BaseRepository
{

    /**
     * 获取当前用户id
     * @return Int
     */
    public function getCurrentId()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->id();
        } else {
            return 0;
        }
    }

    /**
     * 记录操作日志
     * @param  Array  $input [action, params, text, status]
     * @return Array
     */
    public function saveOperateRecord($input)
    {
        DB::table('admin_operate_records')->insert([
            'admin_id'   => $this->getCurrentId(),
            'action'     => $input['action'],
            'params'     => json_encode($input['params']),
            'text'       => $input['text'],
            'ip_address' => getClientIp(),
            'status'     => $input['status'],
        ]);
    }
}
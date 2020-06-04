<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "video_path" => $this->video_path,
            "audio_path" => $this->audio_path,
            "graph_path" => $this->graph_path,
            "model_path" => $this->model_path,
            "content" => $this->content,
            "course_id" => $this->course_id,
            "hasVideo" => !empty($this->video_path) ? "<i class='layui-icon layui-icon-ok'></i>" : "<i class='layui-icon layui-icon-close'></i>",
            "hasAudio" => !empty($this->audio_path)? "<i class='layui-icon layui-icon-ok'></i>" : "<i class='layui-icon layui-icon-close'></i>",
            "hasGraph" => !empty($this->graph_path)? "<i class='layui-icon layui-icon-ok'></i>" : "<i class='layui-icon layui-icon-close'></i>",
            "hasModel" => !empty($this->model_path)? "<i class='layui-icon layui-icon-ok'></i>" : "<i class='layui-icon layui-icon-close'></i>",
            "hasContent" => !empty($this->content)? "<i class='layui-icon layui-icon-ok'></i>" : "<i class='layui-icon layui-icon-close'></i>",
            "created_at" => $this->created_at->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PluginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray0($request)
    {
        return parent::toArray($request);
    }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'repository_url' => $this->repository_url,
            'developer' => $this->developer,
            'install_path' => $this->install_path,
            'plugin_url' => $this->plugin_url,
            'wiki_url' => $this->wiki_url,
            'info_url' => $this->info_url,
            'description' => $this->description,
        ];
    }
}

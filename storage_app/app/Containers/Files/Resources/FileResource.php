<?php
namespace App\Containers\Files\Resources;

use ByteUnits\Metric;
use App\Containers\Share\Resources\ShareResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $fileSize = Metric::bytes($this->filesize)->format();

        return [
            'data' => [
                'id'            => $this->id,
                'uuid'            => $this->uuid,
                'type'          => $this->type,
                'attributes'    => [
                    'filesize'      => $fileSize,
                    'name'          => $this->name,
                    'basename'      => $this->basename,
                    'mimetype'      => $this->mimetype,
                    'file_url'      => $this->file_url,
                    'thumbnail'     => $this->thumbnail,
                    'shared_thumbnail'     => $this->sharedThumbnail,
                    'file_storage_option_id'     => $this->file_storage_option_id,
                    'parent_folder_id'     => $this->parent_folder_id,
                    'file_hash'     => $this->file_hash,
                    'created_at'    => set_time_by_user_timezone($this->user, $this->created_at),
                    'updated_at'    => set_time_by_user_timezone($this->user, $this->updated_at),
                    'deleted_at'    => $this->deleted_at
                        ? set_time_by_user_timezone($this->user, $this->deleted_at)
                        : null,
                ],
                'relationships' => [
                    $this->mergeWhen($this->shared, fn () => [
                        'shared' => new ShareResource($this->shared),
                    ]),
                    $this->mergeWhen($this->parent, fn () => [
                        'parent' => [
                            'data' => [
                                'type'       => 'folder',
                                'id'         => $this->parent->id,
                                'attributes' => [
                                    'name' => $this->parent->name,
                                ],
                            ],
                        ],
                    ]),
                    $this->mergeWhen($this->creator, fn () => [
                        'creator' => [
                            'data' => [
                                'type'       => 'creator',
                                'id'         => $this->creator->id,
                                'attributes' => [
                                    'name'   => $this->creator->name,
                                    'avatar' => $this->creator->userSettings->avatar,
                                    'color'  => $this->creator->userSettings->color,
                                ],
                            ],
                        ],
                    ]),
                    $this->mergeWhen($this->exif, fn () => [
                        'exif' => [
                            'data' => [
                                'type'       => 'exif',
                                'id'         => $this->exif->id,
                                'attributes' => [
                                    'date_time_original' => format_date($this->exif->date_time_original),
                                    'artist'             => $this->exif->artist,
                                    'height'             => $this->exif->height,
                                    'width'              => $this->exif->width,
                                    'x_resolution'       => substr($this->exif->x_resolution, 0, strrpos($this->exif->x_resolution, '/')),
                                    'y_resolution'       => substr($this->exif->y_resolution, 0, strrpos($this->exif->y_resolution, '/')),
                                    'color_space'        => $this->exif->color_space,
                                    'camera'             => $this->exif->camera,
                                    'model'              => $this->exif->model,
                                    'aperture_value'     => intval($this->exif->aperture_value) / 100,
                                    'exposure_time'      => $this->exif->exposure_time,
                                    'focal_length'       => $this->exif->focal_length,
                                    'iso'                => $this->exif->iso,
                                    'aperture_f_number'  => $this->exif->aperture_f_number,
                                    'ccd_width'          => $this->exif->ccd_width,
                                    'longitude'          => formatGPSCoordinates($this->exif->longitude, $this->exif->longitude_ref),
                                    'latitude'           => formatGPSCoordinates($this->exif->latitude, $this->exif->latitude_ref),
                                ],
                            ],
                        ],
                    ]),
                    $this->mergeWhen($this->xrplBlockDocument, fn () => [
                        'xrplBlockDocument' => [
                            'data' => [
                                'id'         => $this->xrplBlockDocument->id,
                                'attributes' => [
                                    'uuid' => $this->xrplBlockDocument->uuid,
                                    'status' => $this->xrplBlockDocument->status,
                                ],
                            ],
                        ],
                    ]),
                ],
            ],
        ];
    }
}

<?php
namespace App\Containers\Files\Tasks;

use Storage;
use App\Containers\Files\Exceptions\StoreExifException;
use App\Containers\Files\Models\Exif;
use Intervention\Image\ImageManagerStatic as Image;

class StoreExifDataTask
{
    public function run(string $path){
        try {
            $mimetype = Storage::mimeType($path);

            // Check if file is jpeg
            if (explode('/', $mimetype)[1] !== 'jpeg') {
                return null;
            }

            // Get Exif data
            $exifRaw = mb_convert_encoding(
                Image::make(Storage::path($path))->exif(),
                'UTF8',
                'UTF8'
            );

            // Convert to object
            $exif = json_decode(json_encode($exifRaw));

            return Exif::create([
                'uuid'            => 'uuid',
                'file_id'            => rand(1,9),
                'date_time_original' => $exif->DateTimeOriginal ?? null,
                'artist'             => $exif->OwnerName ?? null,
                'width'              => $exif->COMPUTED->Width ?? null,
                'height'             => $exif->COMPUTED->Height ?? null,
                'x_resolution'       => $exif->XResolution ?? null,
                'y_resolution'       => $exif->YResolution ?? null,
                'color_space'        => $exif->ColorSpace ?? null,
                'camera'             => $exif->Make ?? null,
                'model'              => $exif->Model ?? null,
                'aperture_value'     => $exif->ApertureValue ?? null,
                'exposure_time'      => $exif->ExposureTime ?? null,
                'focal_length'       => $exif->FocalLength ?? null,
                'iso'                => $exif->ISOSpeedRatings ?? null,
                'aperture_f_number'  => $exif->COMPUTED->ApertureFNumber ?? null,
                'ccd_width'          => $exif->COMPUTED->CCDWidth ?? null,
                'longitude'          => $exif->GPSLongitude ?? null,
                'latitude'           => $exif->GPSLatitude ?? null,
                'longitude_ref'      => $exif->GPSLongitudeRef ?? null,
                'latitude_ref'       => $exif->GPSLatitudeRef ?? null,
            ]);
        } catch (Exception $e) {
            throw (new StoreExifException())->debug($e);
        }
    }
}

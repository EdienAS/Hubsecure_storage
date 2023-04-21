<?php

use Carbon\Carbon;
use ByteUnits\Metric;
use Illuminate\Support\Collection;
use App\Containers\Files\Models\File;
use App\Containers\Traffic\Models\Traffic;
use App\Containers\Settings\Models\Setting;


if (! function_exists('get_restriction_driver')) {
    /**
     * Get driver for limitation API
     */
    function get_restriction_driver(): string
    {
        return match (get_settings('subscription_type')) {
            default   => 'default',
        };
    }
}

if (! function_exists('get_settings')) {
    /**
     * Get single or multiple values from settings table
     */
    function get_settings(array|string $setting): Collection|string|null
    {
        if (is_array($setting)) {
            return Setting::whereIn('name', $setting)
                ->pluck('value', 'name');
        }

        return Setting::find($setting)->value ?? null;
    }
}

if (! function_exists('get_total_uploaded_file_size')) {
    /**
     * Get total upload file size from traffic table
     */
    function get_total_uploaded_file_size($userId)
    {
        return Traffic::where('user_id', $userId)->sum('upload') ?? 0;
    }
}

if (! function_exists('get_total_downloaded_file_size')) {
    /**
     * Get total download file size from traffic table
     */
    function get_total_downloaded_file_size($userId)
    {
        return Traffic::where('user_id', $userId)->sum('download') ?? 0;
    }
}

if (! function_exists('getAllSettings')) {
    /**
     * Get all app settings and return them as json
     */
    function getAllSettings()
    {
        return json_decode(
            Setting::all()
                ->pluck('value', 'name')
                ->toJson()
        );
    }
}

if (! function_exists('format_date')) {
    /**
     * Format localized date
     */
    function format_date($date, string $format = 'd. M. Y, h:i'): string
    {
        $start = Carbon::parse($date);

        return $start->translatedFormat($format);
    }
}

if (! function_exists('get_file_type')) {
    /**
     * Get file type from mimetype
     */
    function getFileType(string $fileMimetype): string
    {
        // Get mimetype from file
        $mimetype = explode('/', $fileMimetype);

        // Check image
        if ($mimetype[0] === 'image' && in_array(strtolower($mimetype[1]), ['jpg', 'jpeg', 'bmp', 'png', 'gif', 'svg', 'svg+xml'])) {
            return 'image';
        }

        // Check video or audio
        if (in_array($mimetype[0], ['video', 'audio'])) {
            return $mimetype[0];
        }

        return 'file';
    }
}

if (! function_exists('toBytes')) {
    /**
     * Convert megabytes to bytes
     *
     * @param $megabytes
     * @return int|string
     */
    function toBytes($megabytes)
    {
        return Metric::megabytes($megabytes)->numberOfBytes();
    }
}

if (! function_exists('sizeFilter')) {
    /**
     * Convert bytes
     *
     * @param $bytes
     * @return int|string
     */
    function sizeFilter($bytes)
    {
        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
        for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
        return( round( $bytes, 2 ) . " " . $label[$i] );
    }
}

if (! function_exists('route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function route($name, $parameters = [], $absolute = true)
    {
        return app('url')->route($name, $parameters, $absolute);
    }
}

if (! function_exists('set_time_by_user_timezone')) {
    /**
     * Set time by user timezone GMT
     */
    function set_time_by_user_timezone($user, $createdAt): string|Carbon
    {
        $timezone = $user->settings->timezone ?? 0;

        return Carbon::parse($createdAt)
            ->addMinutes($timezone * 60)
            ->translatedFormat('d. M. Y, h:i');
    }
}

if (! function_exists('getPrettyName')) {
    /**
     * Format pretty name file
     */
    function getPrettyName(File $file): string
    {
        $file_extension = substr(strrchr($file->basename, '.'), 1);

        if (str_contains($file->name, $file_extension)) {
            return $file->name;
        }

        if ($file_extension) {
            return $file->name . '.' . $file_extension;
        }

        return $file->name . '.' . $file->mimetype;
    }
}

if (! function_exists('recursiveFind')) {
    /**
     * Find all key values in recursive array
     *
     * @param array $array
     * @param $needle
     * @return array
     */
    function recursiveFind(array $array, $needle)
    {
        $iterator = new RecursiveArrayIterator($array);
        $recursive = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
        $aHitList = [];

        foreach ($recursive as $key => $value) {
            if ($key === $needle) {
                array_push($aHitList, $value);
            }
        }

        return $aHitList;
    }
}

if (! function_exists('appeared_once')) {
    /**
     * Get values which appears only once in array
     * @param $arr
     * @return array
     */
    function appeared_once($arr)
    {
        $array_count_values = array_count_values($arr);

        $single_time_comming_values_array = [];

        foreach ($array_count_values as $key => $val) {
            if ($val == 1) {
                $single_time_comming_values_array[] = $key;
            }
        }

        return $single_time_comming_values_array;
    }
}

if (! function_exists('filter_folders_ids')) {
    /**
     * @param $folders
     * @param string $by_column
     * @return array
     */
    function filter_folders_ids($folders, $by_column = 'id')
    {
        $parent_folder_ids = recursiveFind($folders->toArray(), $by_column);

        return appeared_once($parent_folder_ids);
    }
}

if (! function_exists('extractItemsFromGetAttribute')) {
    /**
     * Extract items from get url attribute
     */
    function extractItemsFromGetAttribute(string $string): Collection
    {
        return collect(
            explode(',', $string)
        )->map(function ($chunk) {
            // explode single attribute chunk
            $items = explode('|', $chunk);

            // Abort code if keys doesn't exists
            if (! array_key_exists(0, $items) || ! array_key_exists(1, $items)) {
                abort(
                    response()->json([
                        'type'    => 'error',
                        'message' => 'Incorrect argument format.',
                    ], 422)
                );
            }

            // return item attributes
            return [
                'uuid' => $items[0],
                'type' => $items[1],
            ];
        });
    }

    if (! function_exists('formatPaginatorMetadata')) {
        /**
         * Format paginate data
         */
        function formatPaginatorMetadata(
            int $totalEntries
        ): array {
            $uri = request()->fullUrl();
            $perPage = intval(config('filemanager.paginate.perPage'));
            $lastPage = ceil($totalEntries / $perPage);
            $currentPage = request()->input('page') === 'all'
                ? 1
                : (int) request()->input('page');

            return [
                [
                    'currentPage' => $currentPage,
                    'from'        => 1,
                    'lastPage'    => $lastPage,
                    'path'        => $uri,
                    'perPage'     => $perPage,
                    'to'          => $perPage,
                    'total'       => $totalEntries,
                ],
                [
                    'first' => $uri . '&page=1',
                    'last'  => $uri . '&page=' . $lastPage,
                    'next'  => $currentPage == $lastPage ? null : $uri . '&page=' . $currentPage + 1,
                    'prev'  => $currentPage == 1 ? null : $uri . '&page=' . $currentPage - 1,
                ],
            ];
        }
    }

    if (! function_exists('getRecordsCount')) {
        /**
         * Get count of items from the Database
         */
        function getRecordsCount(
            array $query,
            string $page = 'all',
            bool $findTrashed = false,
        ): array {
            $perPage = config('filemanager.paginate.perPage');
            $currentPage = $page === 'all' ? 'all' : intval($page);

            $foldersSkip = $foldersTake = $filesSkip =
            $filesTake = $foldersCount = $filesCount = 0;

            if(isset($query['folder'])){
                $foldersCount = DB::table('folders')
                    ->when(
                        $findTrashed,
                        fn ($q) => $q->whereNotNull('deleted_at')
                    )
                    ->when(
                        array_key_exists('where', $query['folder']),
                        fn ($q) => $q->where($query['folder']['where'])
                    )
                    ->when(
                        array_key_exists('whereIn', $query['folder']),
                        function ($q) use ($query) {
                            foreach ($query['folder']['whereIn'] as $key => $value) {
                                $q->whereIn($key, $value);
                            }

                            return $q;
                        }
                    )
                    ->count();
            }

            if(isset($query['file'])){
                $filesCount = DB::table('files')
                    ->when(
                        $findTrashed,
                        fn ($q) => $q->whereNotNull('deleted_at')
                    )
                    ->when(
                        array_key_exists('where', $query['file']),
                        fn ($q) => $q->where($query['file']['where'])
                    )
                    ->when(
                        array_key_exists('whereIn', $query['file']),
                        function ($q) use ($query) {
                            foreach ($query['file']['whereIn'] as $key => $value) {
                                $q->whereIn($key, $value);
                            }

                            return $q;
                        }
                    )
                    ->count();
            }

            $totalEntries = $foldersCount + $filesCount;

            // Get certain page
            if ($page !== 'all') {
                // Folders pages
                if ($foldersCount >= $currentPage * $perPage) {
                    $foldersTake = $perPage;
                    $foldersSkip = ($currentPage - 1) * $perPage;
                }

                // Mixed page
                if ($foldersCount < $currentPage * $perPage && ceil($currentPage) === ceil($foldersCount / $perPage)) {
                    $foldersSkip = ($currentPage - 1) * $perPage;
                    $foldersTake = $foldersCount - $foldersSkip;
                    $filesTake = ($currentPage * $perPage) - $foldersCount;
                    $filesSkip = 0;
                }

                // Files pages
                if ($currentPage > ceil($foldersCount / $perPage)) {
                    $filesTake = $perPage;
                    $filesSkip = ((ceil($foldersCount / $perPage) * $perPage) - $foldersCount) + ($currentPage - (ceil($foldersCount / $perPage)) - 1) * $perPage;
                }
            }

            // Get all records
            if ($page === 'all') {
                $foldersTake = $foldersCount;
                $filesTake = $filesCount;
            }

            return [$foldersTake, $foldersSkip, $filesTake, $filesSkip, $totalEntries];
        }
    }
}

if (! function_exists('isStorageDriver')) {
    /**
     * Check if is running AWS s3 as storage
     */
    function isStorageDriver(string|array $driver): bool
    {
        if (is_array($driver)) {
            return in_array(config('filesystems.default'), $driver);
        }

        return config('filesystems.default') === $driver;
    }
}

if (! function_exists('get_files_for_zip')) {
    /**
     * Get all files from folder and get their folder location
     */
    function get_files_for_zip($folders, $files, array $path = []): array
    {
        // Return file list
        if (! isset($folders->folders)) {
            return $files->unique()->values()->all();
        }

        // Push file path
        array_push($path, $folders->name);

        // Push file to collection
        $folders->files->each(function ($file) use ($files, $path) {
            $files->push([
                'name'        => $file->name,
                'user_id'     => $file->user_id,
                'basename'    => $file->basename,
                'mimetype'    => $file->mimetype,
                'file_storage_option_id'    => $file->file_storage_option_id,
                'folder_path' => implode('/', $path),
                'xrpl_block_document_id' => $file->xrpl_block_document_id,
                'xrplBlockDocument' => $file->xrplBlockDocument
            ]);
        });

        // Get all children folders and folders within
        if ($folders->folders->isNotEmpty()) {
            $folders->folders->map(fn ($folder) => get_files_for_zip($folder, $files, $path));
        }

        return get_files_for_zip($folders->folders->first(), $files, $path);
    }
}

if (! function_exists('get_item_by_uuid')) {
    /**
     * Get folder or file item
     */
    function get_item_by_uuid(string $type, string $uuid){
        $model = $type === 'folder'
            ? 'folder'
            : 'file';

        $namespace = match ($model) {
            'folder' => 'App\\Containers\\Folders\\Models\\Folder',
            'file'   => 'App\\Containers\\Files\\Models\\File',
        };

        // Get item
        $entry = ($namespace)::withTrashed()
            ->where('uuid', $uuid)->first();

        if (! $entry) {
            abort(response()->json(entryNotFoundError()), 404);
        }

        return $entry;
    }
}

if (! function_exists('get_item_by_id')) {
    /**
     * Get folder or file item
     */
    function get_item_by_id(string $type, int $id){
        $model = $type === 'folder'
            ? 'folder'
            : 'file';

        $namespace = match ($model) {
            'folder' => 'App\\Containers\\Folders\\Models\\Folder',
            'file'   => 'App\\Containers\\Files\\Models\\File',
        };

        // Get item
        $entry = ($namespace)::withTrashed()
            ->where('id', $id)->first();

        if (! $entry) {
            abort(response()->json(entryNotFoundError()), 404);
        }

        return $entry;
    }
}

if (! function_exists('is_visitor')) {
    /**
     * Check if shared permission is visitor
     *
     * @param $shared
     * @return bool
     */
    function is_visitor($shared)
    {
        return $shared->permission === 'visitor';
    }
}

if (! function_exists('__t')) {
    /**
     * Translate the given message.
     * @param $key
     * @param null $values
     * @return string
     * @throws Exception
     */
    function __t($key, $values = null): string
    {
        // Get current locale
        $locale = cache()->rememberForever('language', function () {
            try {
                return get_settings('language') ?? 'en';
            } catch (QueryException $e) {
                return 'en';
            }
        });

        // Get language strings
        $strings = cache()->rememberForever("language-translations-$locale", function () use ($locale) {
            try {
                return Language::whereLocale($locale)->firstOrFail()->languageTranslations;
            } catch (QueryException | ModelNotFoundException $e) {
                return null;
            }
        }) ?? get_default_language_translations();

        // Find the string by key
        $string = $strings->firstWhere('key', $key)->value ?? $strings->get($key);

        if ($values) {
            return replace_occurrence($string, collect($values));
        }

        return $string;
    }
}

    if (! function_exists('formatGPSCoordinates')) {
        /**
         * Format GPS coordinates
         */
        function formatGPSCoordinates($coordinates, $ref): string|null
        {
            if (! $coordinates && ! $ref) {
                return null;
            }

            $degrees = explode('/', $coordinates[0])[0];
            $minutes = explode('/', $coordinates[1])[0];
            $seconds = intval(substr(explode(',', $coordinates[2])[0], 0, 5)) / 100;

            return "{$degrees}°$minutes'$seconds\"$ref";
        }
    }

if (! function_exists('getThumbnailFileList')) {
    /**
     * Get list of image thumbnails
     */
    function getThumbnailFileList(string $basename): Collection
    {
        return collect([
            config('filemanager.image_sizes.later'),
            config('filemanager.image_sizes.immediately'),
        ])->collapse()
            ->map(fn ($item) => $item['name'] . '-' . $basename);
    }
}

if (! function_exists('seems_utf8')) {
    /**
     * @param $str
     * @return bool
     */
    function seems_utf8($str)
    {
        $length = strlen($str);

        for ($i = 0; $i < $length; $i++) {
            $c = ord($str[$i]);

            if ($c < 0x80) {
                $n = 0;
            } # 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) {
                $n = 1;
            } # 110bbbbb
            elseif (($c & 0xF0) == 0xE0) {
                $n = 2;
            } # 1110bbbb
            elseif (($c & 0xF8) == 0xF0) {
                $n = 3;
            } # 11110bbb
            elseif (($c & 0xFC) == 0xF8) {
                $n = 4;
            } # 111110bb
            elseif (($c & 0xFE) == 0xFC) {
                $n = 5;
            } # 1111110b
            else {
                return false;
            } # Does not match any model

            for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80)) {
                    return false;
                }
            }
        }

        return true;
    }
}

if (! function_exists('remove_accents')) {
    /**
     * Converts all accent characters to ASCII characters.
     *
     * If there are no accent characters, then the string given is just returned.
     *
     * @param string $string Text that might have accent characters
     * @return string Filtered string with replaced "nice" characters.
     */
    function remove_accents($string)
    {
        if (! preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }

        if (seems_utf8($string)) {
            $chars = [
                // Decompositions for Latin-1 Supplement
                chr(195) . chr(128)            => 'A', chr(195) . chr(129) => 'A',
                chr(195) . chr(130)            => 'A', chr(195) . chr(131) => 'A',
                chr(195) . chr(132)            => 'A', chr(195) . chr(133) => 'A',
                chr(195) . chr(135)            => 'C', chr(195) . chr(136) => 'E',
                chr(195) . chr(137)            => 'E', chr(195) . chr(138) => 'E',
                chr(195) . chr(139)            => 'E', chr(195) . chr(140) => 'I',
                chr(195) . chr(141)            => 'I', chr(195) . chr(142) => 'I',
                chr(195) . chr(143)            => 'I', chr(195) . chr(145) => 'N',
                chr(195) . chr(146)            => 'O', chr(195) . chr(147) => 'O',
                chr(195) . chr(148)            => 'O', chr(195) . chr(149) => 'O',
                chr(195) . chr(150)            => 'O', chr(195) . chr(153) => 'U',
                chr(195) . chr(154)            => 'U', chr(195) . chr(155) => 'U',
                chr(195) . chr(156)            => 'U', chr(195) . chr(157) => 'Y',
                chr(195) . chr(159)            => 's', chr(195) . chr(160) => 'a',
                chr(195) . chr(161)            => 'a', chr(195) . chr(162) => 'a',
                chr(195) . chr(163)            => 'a', chr(195) . chr(164) => 'a',
                chr(195) . chr(165)            => 'a', chr(195) . chr(167) => 'c',
                chr(195) . chr(168)            => 'e', chr(195) . chr(169) => 'e',
                chr(195) . chr(170)            => 'e', chr(195) . chr(171) => 'e',
                chr(195) . chr(172)            => 'i', chr(195) . chr(173) => 'i',
                chr(195) . chr(174)            => 'i', chr(195) . chr(175) => 'i',
                chr(195) . chr(177)            => 'n', chr(195) . chr(178) => 'o',
                chr(195) . chr(179)            => 'o', chr(195) . chr(180) => 'o',
                chr(195) . chr(181)            => 'o', chr(195) . chr(182) => 'o',
                chr(195) . chr(182)            => 'o', chr(195) . chr(185) => 'u',
                chr(195) . chr(186)            => 'u', chr(195) . chr(187) => 'u',
                chr(195) . chr(188)            => 'u', chr(195) . chr(189) => 'y',
                chr(195) . chr(191)            => 'y',
                // Decompositions for Latin Extended-A
                chr(196) . chr(128)            => 'A', chr(196) . chr(129) => 'a',
                chr(196) . chr(130)            => 'A', chr(196) . chr(131) => 'a',
                chr(196) . chr(132)            => 'A', chr(196) . chr(133) => 'a',
                chr(196) . chr(134)            => 'C', chr(196) . chr(135) => 'c',
                chr(196) . chr(136)            => 'C', chr(196) . chr(137) => 'c',
                chr(196) . chr(138)            => 'C', chr(196) . chr(139) => 'c',
                chr(196) . chr(140)            => 'C', chr(196) . chr(141) => 'c',
                chr(196) . chr(142)            => 'D', chr(196) . chr(143) => 'd',
                chr(196) . chr(144)            => 'D', chr(196) . chr(145) => 'd',
                chr(196) . chr(146)            => 'E', chr(196) . chr(147) => 'e',
                chr(196) . chr(148)            => 'E', chr(196) . chr(149) => 'e',
                chr(196) . chr(150)            => 'E', chr(196) . chr(151) => 'e',
                chr(196) . chr(152)            => 'E', chr(196) . chr(153) => 'e',
                chr(196) . chr(154)            => 'E', chr(196) . chr(155) => 'e',
                chr(196) . chr(156)            => 'G', chr(196) . chr(157) => 'g',
                chr(196) . chr(158)            => 'G', chr(196) . chr(159) => 'g',
                chr(196) . chr(160)            => 'G', chr(196) . chr(161) => 'g',
                chr(196) . chr(162)            => 'G', chr(196) . chr(163) => 'g',
                chr(196) . chr(164)            => 'H', chr(196) . chr(165) => 'h',
                chr(196) . chr(166)            => 'H', chr(196) . chr(167) => 'h',
                chr(196) . chr(168)            => 'I', chr(196) . chr(169) => 'i',
                chr(196) . chr(170)            => 'I', chr(196) . chr(171) => 'i',
                chr(196) . chr(172)            => 'I', chr(196) . chr(173) => 'i',
                chr(196) . chr(174)            => 'I', chr(196) . chr(175) => 'i',
                chr(196) . chr(176)            => 'I', chr(196) . chr(177) => 'i',
                chr(196) . chr(178)            => 'IJ', chr(196) . chr(179) => 'ij',
                chr(196) . chr(180)            => 'J', chr(196) . chr(181) => 'j',
                chr(196) . chr(182)            => 'K', chr(196) . chr(183) => 'k',
                chr(196) . chr(184)            => 'k', chr(196) . chr(185) => 'L',
                chr(196) . chr(186)            => 'l', chr(196) . chr(187) => 'L',
                chr(196) . chr(188)            => 'l', chr(196) . chr(189) => 'L',
                chr(196) . chr(190)            => 'l', chr(196) . chr(191) => 'L',
                chr(197) . chr(128)            => 'l', chr(197) . chr(129) => 'L',
                chr(197) . chr(130)            => 'l', chr(197) . chr(131) => 'N',
                chr(197) . chr(132)            => 'n', chr(197) . chr(133) => 'N',
                chr(197) . chr(134)            => 'n', chr(197) . chr(135) => 'N',
                chr(197) . chr(136)            => 'n', chr(197) . chr(137) => 'N',
                chr(197) . chr(138)            => 'n', chr(197) . chr(139) => 'N',
                chr(197) . chr(140)            => 'O', chr(197) . chr(141) => 'o',
                chr(197) . chr(142)            => 'O', chr(197) . chr(143) => 'o',
                chr(197) . chr(144)            => 'O', chr(197) . chr(145) => 'o',
                chr(197) . chr(146)            => 'OE', chr(197) . chr(147) => 'oe',
                chr(197) . chr(148)            => 'R', chr(197) . chr(149) => 'r',
                chr(197) . chr(150)            => 'R', chr(197) . chr(151) => 'r',
                chr(197) . chr(152)            => 'R', chr(197) . chr(153) => 'r',
                chr(197) . chr(154)            => 'S', chr(197) . chr(155) => 's',
                chr(197) . chr(156)            => 'S', chr(197) . chr(157) => 's',
                chr(197) . chr(158)            => 'S', chr(197) . chr(159) => 's',
                chr(197) . chr(160)            => 'S', chr(197) . chr(161) => 's',
                chr(197) . chr(162)            => 'T', chr(197) . chr(163) => 't',
                chr(197) . chr(164)            => 'T', chr(197) . chr(165) => 't',
                chr(197) . chr(166)            => 'T', chr(197) . chr(167) => 't',
                chr(197) . chr(168)            => 'U', chr(197) . chr(169) => 'u',
                chr(197) . chr(170)            => 'U', chr(197) . chr(171) => 'u',
                chr(197) . chr(172)            => 'U', chr(197) . chr(173) => 'u',
                chr(197) . chr(174)            => 'U', chr(197) . chr(175) => 'u',
                chr(197) . chr(176)            => 'U', chr(197) . chr(177) => 'u',
                chr(197) . chr(178)            => 'U', chr(197) . chr(179) => 'u',
                chr(197) . chr(180)            => 'W', chr(197) . chr(181) => 'w',
                chr(197) . chr(182)            => 'Y', chr(197) . chr(183) => 'y',
                chr(197) . chr(184)            => 'Y', chr(197) . chr(185) => 'Z',
                chr(197) . chr(186)            => 'z', chr(197) . chr(187) => 'Z',
                chr(197) . chr(188)            => 'z', chr(197) . chr(189) => 'Z',
                chr(197) . chr(190)            => 'z', chr(197) . chr(191) => 's',
                // Euro Sign
                chr(226) . chr(130) . chr(172) => 'E',
                // GBP (Pound) Sign
                chr(194) . chr(163)            => '', ];

            $string = strtr($string, $chars);
        } else {
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                . chr(252) . chr(253) . chr(255);

            $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars['in'] = [chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254)];
            $double_chars['out'] = ['OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th'];
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }
}


if (! function_exists('getRandomWord')) {
    
    /*
     * Generate random word
     * 
     * @param $len Length of a word
     * @return word
     */
    
    function getRandomWord($len) {
        $word = range('A', 'Z');
        shuffle($word);
        return substr(implode($word), 0, $len);
    }
}

if (! function_exists('generateRandomPhrase')) {
    
    /*
     * Generate phrase with random words
     * 
     * @return phrase of random words
     */
    
    function generateRandomPhrase() {

        for ($i=0;$i<5;$i++){
            $len = rand(4,8);
            $words[] = getRandomWord($len);
        }
        return implode(' ', $words);

    }
}
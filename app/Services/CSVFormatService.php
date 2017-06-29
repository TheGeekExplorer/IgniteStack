<?php namespace igniteStack\app\Services;


class CSVFormatService
{
    /**
     * Get all adverts for all time, of all types (awaiting/approved/rejected)
     * @param $data_array
     * @return string
     */
    final public static function array_to_csv ($data_array)
    {
        $data=''; $tmp='';

        # Set CSV headers
        foreach ($data_array[0] as $key => $value) {
            $data .= '"' . $key . '",';
        }
        $data = rtrim($data, ",") . "\n";

        # Set CSV Data
        foreach ($data_array as $item) {
            foreach ($item as $k => $v) {
                $tmp  .= '"' . $v . '",';
            }
            # Trim comma off end of line
            $data .= rtrim($tmp, ",") . "\n";
            $tmp='';
        }
        return $data;
    }
}

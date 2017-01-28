<?php

namespace ConorSmith\Music\Remote;

use League\Csv\Reader as CsvReader;

class GoogleDrive
{
    private $api;
    private $importer;

    private $sheetId = "1QjvQu-m1HQStiI5fY_rzemwSrCm9i4OriKxRSRzEU08";
    private $sheetGids = [1270329184, 1399182865, 4, 3, 2, 0, 1];

    public function __construct(\Google_Service_Drive $api, GoogleSheetsImporter $importer)
    {
        $this->api = $api;
        $this->importer = $importer;
    }

    public function requestAlbums()
    {
        $sheet = $this->api->files->get($this->sheetId);
        $baseUrl = $sheet->getExportLinks()['text/csv'];

        $rows = [];

        foreach ($this->sheetGids as $gid) {
            $csv = CsvReader::createFromString(file_get_contents($baseUrl . "&gid=" . $gid));
            $rows = array_merge($csv->fetchAssoc(), $rows);
        }

        //return $this->importer->importRows($rows);
        return GoogleSheetsImport::fromUnprocessedRows($rows);
    }
}

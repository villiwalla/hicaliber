<?php

use App\House;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{

    public function run()
    {
        $collection = $this->getPrepareData();


        if($collection->count()) {
            factory(House::class, $collection->count())
                ->make()
                ->each(fn ($house) => $collection->shift()->save());
        } else {
            factory(House::class, 20)->create();
        }

    }

    /**
     * Get demo demo data.
     *
     * @return Collection<House>
     */
    protected function getPrepareData(): Collection {
        $collection = new Collection();
        $this->demoFile = base_path() . '/property-data.csv';

        if(file_exists($this->demoFile)) {
            $fd = fopen($this->demoFile, 'r');
            $skipHeader = true;

            while ($row = fgetcsv($fd)) {
                if ($skipHeader) {
                    $skipHeader = false;
                    continue;
                }

                $collection->add(new House([
                    'name'     => $row[0],
                    'price'    => $row[1],
                    'bedroom'  => $row[2],
                    'bathroom' => $row[3],
                    'storey'   => $row[4],
                    'garage'   => $row[5],
                ]));
            }

            fclose($fd);
        }

        return $collection;
    }
}

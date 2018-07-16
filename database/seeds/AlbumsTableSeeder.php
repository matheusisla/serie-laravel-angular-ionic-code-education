<?php

use Illuminate\Database\Seeder;
use App\Album;
use App\Photo;
use Faker\Factory;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $self = $this;
        \File::deleteDirectory(storage_path('app'), true);
        /**
         *
         * Chamo o objeto factory ele é nativo do laravel não precisa instanciar lá em
         * cima passo como parametro o model que eu quero utilizar e a quantidade de registros que eu quero
         * É obrigatório colocar o método create() para ele registrar no banco de dados
         * each recebe a estancia do objeto criado
         * o $self é refencia ao this da classe
         */
        factory(Album::class, 10)->create()
            ->each(function ($album) use ($self) {
                $self->generatePhotos($album);
            });
    }

    private function generatePhotos(Album $album)
    {
        $albumdir = storage_path("app/{$album->id}");
        //criando o diretório
        \File::makeDirectory($albumdir);
        $faker = Factory::create();
        //make só gera a instancia e não salva no bancos necessário fazer manualmente
        factory(Photo::class, 5)->make()
            ->each(function ($photo) use ($album, $faker, $albumdir) {
                $photo->album_id = $album->id;
                /**
                 * ativar extensão curl
                 * importante colocar o ultímo paragrafo vazio para salvar apenas o
                 * nome do arquivo se não irá salvar o caminho completo
                 */
                $photo->file_name = $faker->image($albumdir, 800, 600, 'city', false);
                $photo->save();
            });
    }
}

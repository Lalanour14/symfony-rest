<?php
namespace App\Repository;

use App\Entity\Genre;
use DateTime;
use App\Entity\Movie;

class MovieRepository
{

    /**
     * Summary of findAll
     * @return array
     */
    public function findAll(): array
    {

        $list = [];
        $connection = Database::getConnection();
        $query = $connection->prepare("SELECT *,movie.id movie_id ,genre.id genre_id FROM movie 
        LEFT JOIN genre_movie ON movie.id = genre_movie.id_movie 
        LEFT JOIN genre ON genre.id = genre_movie.id_genre;");

        $query->execute();
        /**
         * @var ?Movie
         */
        $currentMovie = null;

        foreach ($query->fetchAll() as $line) {
            if ($currentMovie != null && $currentMovie->getId() == $line['movie_id']) {
                $currentMovie->addGenre(new Genre($line['label'], $line['id']));
            } else {
                $currentMovie = new Movie($line['Title'], $line['Resume'], new DateTime($line['DATE']), $line['duration'], $line['movie_id']);
                $list[] = $currentMovie;

                if (isset($line['genre_id'])) {
                    $currentMovie->addGenre(new Genre($line['label'], $line['id']));
                }
            }

        }

        return $list;
    }


    public function findById(int $id): ?Movie
    {

        $connection = Database::getConnection();
        $query = $connection->prepare("SELECT * FROM movie WHERE id=:id");
        $query->bindValue(':id', $id);
        $query->execute();

        foreach ($query->fetchAll() as $line) {
            return new Movie($line['Title'], $line['Resume'], new DateTime($line['DATE']), $line['duration'], $line['id']);
        }
        return null;
    }

    public function persite(Movie $movie): void
    {
        $connection = Database::getConnection();
        $query = $connection->prepare('insert into movie (Title,Resume,Date,duration ) values(:Title,:Resume,:Date,:duration)');

        $query->bindValue(':Title', $movie->getTitle());
        $query->bindValue(':Resume', $movie->getResume());
        $query->bindValue(':Date', $movie->getDate()->format('Y-m-d H:i:s'));
        $query->bindValue(':duration', $movie->getDuration());
        $query->execute();
        $movie->setId($connection->lastInsertId());
    }

    public function upDate(Movie $movie): void
    {
        $connection = Database::getConnection();
        $query = $connection->prepare('UPDATE movie SET Titlt=:Title,Resume=:Resume,Date=:Date,duration:duration where id=:id');
        $query->bindValue(':Title', $movie->getTitle());
        $query->bindValue(':Resume', $movie->getResume());
        $query->bindValue(':Date', $movie->getDate()->format('Y-m-d H:i:s'));
        $query->bindValue(':duration', $movie->getDuration());
        $query->bindValue(':id', $movie->getId());
        $query->execute();

    }


    public function delete(int $id): void
    {

        $connection = Database::getConnection();
        $query = $connection->prepare("DELETE FROM movie WHERE id=:id");
        $query->bindValue(':id', $id);
        $query->execute();

    }



}
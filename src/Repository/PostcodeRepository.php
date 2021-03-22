<?php

namespace App\Repository;

use App\Entity\Postcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Postcode[] findByPartialMatch(string $partial)
 * @method Postcode[] findByLocation(float $lat, float $long, float $range)
 */
class PostcodeRepository extends ServiceEntityRepository
{
    private const EARTH_RADIUS              = 6371; // Radius of earth in km
    private const KM_PER_DEGREE_LATITUDE    = 111;  // Km in a degree of latitude
    private const KM_PER_DEGREE_LONGITUDE   = 111;  // Km in a degree of longitude at the equator

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postcode::class);
    }

    /**
     * @param string $partial
     *
     * @return Postcode[]
     */
    public function findByPartialMatch(string $partial): array
    {
        return $this->createQueryBuilder('postcode')
            ->andWhere('postcode.postcode LIKE :partial')
            ->setParameter('partial', "%$partial%")
            ->orderBy('postcode.postcode', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param float $lat
     * @param float $long
     * @param float $range
     *
     * @return Postcode[]
     */
    public function findByLocation(float $lat, float $long, float $range): array
    {
        // Broad phase
        // Calculate latitude/longitude offsets for the top-left and bottom-right corners of the search area
        $latitudeOffset = $range / self::KM_PER_DEGREE_LATITUDE;
        $longitudeOffset = $range / $this->calculateKmPerDegreeLongitude($lat);
        $top = $lat - $latitudeOffset;
        $left = $long - $longitudeOffset;
        $bottom = $lat + $latitudeOffset;
        $right = $long + $longitudeOffset;

        // Find all postcodes in the search area
        // ...

        // Narrow phase
        // Filter results within search radius

        return [];
    }

    /**
     * Calculate the distance between points a and b in km
     * https://en.wikipedia.org/wiki/Haversine_formula
     *
     * Doesn't take into account the ellipsoidal shape of the Earth - will overestimate transpolar distances
     * and underestimate transequitorial distances.
     *
     * @param float $latitudeA
     * @param float $longitudeA
     * @param float $latitudeB
     * @param float $longitudeB
     *
     * @return float
     */
    private function calculateDistance(
        float $latitudeA,
        float $longitudeA,
        float $latitudeB,
        float $longitudeB
    ): float {
        $phi1 = deg2rad($latitudeA);
        $phi2 = deg2rad($latitudeB);
        $deltaLatitude = deg2rad($latitudeB - $latitudeA);
        $deltaLongitude = deg2rad($longitudeB - $longitudeA);

        $a = sin($deltaLatitude / 2) ** 2 + cos($phi1) * cos($phi2) * sin($deltaLongitude / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS * $c;
    }

    /**
     * Calculate how many km in a degree of longitude at a specific latitude. Latitude degrees
     * are parallel, but longitude degrees converge to 0 at the poles.
     *
     * @param float $longitude
     *
     * @return float
     */
    private function calculateKmPerDegreeLongitude(float $latitude): float
    {
        return cos(deg2rad($latitude)) * self::KM_PER_DEGREE_LONGITUDE;
    }
}

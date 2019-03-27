<?php
/**
 * @author Krystian Jasnos <dzejson91@gmail.com>
 */

namespace JasonMx\SettingsBundle\Repository;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use JasonMx\SettingsBundle\Entity\SettingsItem;

/**
 * Class SettingsRepository
 * @package JasonMx\SettingsBundle\Repository
 */
class SettingsRepository extends EntityRepository
{
    /**
     * @param null $locale
     * @param null $groupName
     * @return ArrayCollection|SettingsItem[]
     */
    public function loadSettings($locale = null, $groupName = null)
    {
        $qb = $this->createQueryBuilder('s')
            ->select('s, g')
            ->leftJoin('s.group', 'g')
        ;

        if(isset($groupName)) {
            $qb
                ->andWhere('g.name = :groupName')
                ->setParameter('groupName', $groupName)
            ;
        }

        if(!is_null($locale)) {
            $qb
                ->andWhere('s.locale IS NULL OR s.locale = :locale')
                ->setParameter('locale', $locale)
            ;
        } else {
            $qb->andWhere('s.locale IS NULL');
        }

        $query = $qb->getQuery();
        $results = new ArrayCollection();
        foreach($query->getResult() as $setting)
        {
            /** @var SettingsItem $setting */
            if(!$results->containsKey($setting->getKey()) || ($setting->getLocale() !== null)){
                $results[$setting->getKey()] = $setting;
            }
        }
        return $results;
    }
}
<?php

namespace Intra\CorrectionBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CorrectionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CorrectionRepository extends EntityRepository
{
	public function getCorrection($id_correcteur, $id_corrige, $id_activite)
	{
		$query = $this->createQueryBuilder('a')
	    			   ->where("a.corrige = '" . $id_corrige . 
	    			   	"' and a.correcteur = '" . $id_correcteur .
	    			   	"' and a.activite = '" . $id_activite . "'")
	                  ->getQuery();

	 	return $query->getResult();
	}

	public function getCorrectionUser($id_user, $id_activite)
	{
		$query = $this->createQueryBuilder('a')
	    			   ->where("a.correcteur = '" . $id_user . "' and a.activite = '" . $id_activite ."'")
	                  ->getQuery();

	 	return $query->getResult();
	}

	public function getCorrectionToUser($id_user, $id_activite)
	{
		$query = $this->createQueryBuilder('a')
	    			   ->where("a.corrige = '" . $id_user . "' and a.activite = '" . $id_activite ."'")
	                  ->getQuery();

	 	return $query->getResult();
	}
}

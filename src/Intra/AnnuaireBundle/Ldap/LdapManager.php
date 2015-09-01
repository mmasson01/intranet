<?php

namespace Intra\AnnuaireBundle\Ldap;

use FR3D\LdapBundle\Ldap\LdapManager as BaseLdapManager;
use FR3D\LdapBundle\Model\LdapUserInterface;
use FR3D\LdapBundle\Driver\LdapDriverInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class LdapManager extends BaseLdapManager
{
	/**
     * Hydrates an user entity with ldap attributes.
     *
     * @param  UserInterface $user  user to hydrate
     * @param  array         $entry ldap result
     *
     * @return UserInterface
     */
    protected function hydrate(UserInterface $user, array $entry)
    {
    	parent::hydrate($user, $entry);
        $user->setPassword('');

        if ($user instanceof AdvancedUserInterface) {
            $user->setEnabled(true);
        }

        foreach ($this->params['attributes'] as $attr) {
            $ldapValue = $entry[$attr['ldap_attr']];
            $value = null;

            if (!array_key_exists('count', $ldapValue) ||  $ldapValue['count'] == 1) {
                $value = $ldapValue[0];
            } else {
                $value = array_slice($ldapValue, 1);
            }

            call_user_func(array($user, $attr['user_method']), $value);
        }

        if ($user instanceof LdapUserInterface) {
            $user->setLogin($entry['uid'][0]);
            $user->setDn($entry['dn']);
            $user->setMail($entry['alias'][0]);
            $user->setName($entry['cn'][0]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findUsersBy(array $criteria)
    {
        $filter  = $this->buildFilterLike($criteria);
        $entries = $this->driver->search($this->params['baseDn'], $filter, $this->ldapAttributes);

        if ($entries['count'] == 0) {
            return false;
        }

        $users = array();
        $len = $entries['count'];
        for($i = 0; $i < $len; $i++)
        {
            $user = $this->userManager->createUser();
            $this->hydrate($user, $entries[$i]);
            $users[] = $user;
        }

        return $users;
    }

     /**
     * {@inheritDoc}
     */
    public function findUsersByWithLetter($letter)
    {
        $filter  = $this->buildFilter(array());
        $entries = $this->driver->search($this->params['baseDn'], $filter, $this->ldapAttributes);

        if ($entries['count'] == 0) {
            return false;
        }

        $users = array();
        $len = $entries['count'];
        for($i = 0; $i < $len; $i++)
        {
            $user = $this->userManager->createUser();
            $this->hydrate($user, $entries[$i]);
            if ($user->getLogin()[0] === $letter)
                $users[] = $user;
        }

        return $users;
    }

    /**
     * Build Ldap filter
     *
     * @param  array  $criteria
     * @param  string $condition
     * @return string
     */
    protected function buildFilterLike(array $criteria, $condition = '&')
    {
        $criteria = self::escapeValue($criteria);
        $filters = array();
        $filters[] = $this->params['filter'];
        foreach ($criteria as $key => $value) {
            $filters[] = sprintf('(%s~=%s)', $key, $value);
        }

        return sprintf('(%s%s)', $condition, implode($filters));
    }
}
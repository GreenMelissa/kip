<?php

namespace app\service;

use yii\base\BaseObject;

/**
 * Сервис для работы с LDAP
 */
class LdapService extends BaseObject
{
    public $ldaprdn;
    public $ldappass;
    public $ldapurl;

    /**
     * Инициализация аутентификационных данных для LDAP сервера
     */
    public function init()
    {
        $this->ldaprdn = \Yii::$app->params['ldaprdn'];
        $this->ldappass = \Yii::$app->params['ldappass'];
        $this->ldapurl = \Yii::$app->params['ldapurl'];
    }

    /**
     * Попытка найти пользователя в LDAP
     */
    public function findLdapUser(string $username): ?array
    {
        try {
            // подключение к серверу ldap
            $ldapconn = ldap_connect($this->ldapurl);

            // настройка протокола
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

            // при успешном подключении и бинде делаем запрос, чтобы найти пользователя
            if ($ldapconn) {
                $ldapbind = ldap_bind($ldapconn, $this->ldaprdn, $this->ldappass);
                if ($ldapbind) {
                    $result = ldap_search(
                        $ldapconn,
                        'ou=User,dc=example,dc=com',
                        '(uid=' . $username . ')'
                    );
                    $data = ldap_get_entries($ldapconn, $result);
                    return $data;
                }
            }

            return [];
        } catch (\Throwable $exception) {
            \Yii::$app->errorHandler->logException($exception);
            return null;
        }
    }

    public function getLdapUserList(): array
    {
        $userList = [];
        $data = $this->findLdapUser('*');
        foreach ($data as $item) {
            if ($item['uid'] ?? null) {
                $userList[$item['uid'][0]] = $item['displayname'][0];
            }
        }
        return $userList;
    }
}
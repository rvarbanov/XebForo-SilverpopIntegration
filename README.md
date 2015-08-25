# XenForo Silverpop Integration Add-on

This is an add-on for XenForo that allows you to integrate Silverpop

SELECT u.user_id AS xf_user_id, u.username AS xf_username, u.email AS Email, IF(uo.receive_admin_email = 0, 'No', 'Yes') AS _newswire_subscription
FROM xf_user u
JOIN xf_user_option uo ON u.user_id = uo.user_id
WHERE 1
AND uo.receive_admin_email = 1
AND u.user_state = 'valid'
AND u.is_banned = 0
AND u.email != ''

LIMIT 0, 9999999999999

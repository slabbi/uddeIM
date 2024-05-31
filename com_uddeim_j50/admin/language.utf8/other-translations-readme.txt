if you want to use other (old) language scripts
delivered with older uddeIM versions you

-- MUST include -- the new defines (new_defines_v5+.php)
(you may translate them or not)

other than standard *.ini translation files uddeIM uses php defines
as language scripts, so if a translate string (define) is not found,
it not simply uses the string as with *.ini files BUT

---------  stop the whole script with a Fatal Error. ------------

<?php
function is_user($_what, $_col = 'title')
{ 
	$_roles = auth()->user()->load(['roles'])->roles->toArray();

    $role_ = array_filter(
        $_roles,
        function ($_role) use ($_what, $_col) {
            return $_role[$_col] == $_what;
        }
    );

    if(count($role_)){
    	return true;
    }

    return false;
}

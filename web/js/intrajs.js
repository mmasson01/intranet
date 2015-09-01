function checkLength(champ)
{
	if (champ.value.length < 3)
		return false;
	else
		return true;
}

function checkSearch(f)
{
	if (checkLength(f._q))
		return true;
	$(f._q).popover('show');
	return false;
}

function checkEmpty(champ)
{
	if (champ.value.length < 1)
		return false;
	else
		return true;
}

function checkForm(f)
{
	if (checkEmpty(f._name))
		return true;
	return false;
}

function ajoutFormulaire(com)
{
	if (com)
		alert('comment');
	return true;
}
<?php

namespace VX\User;

interface Favoriteable
{
    function addFavorite(string $label, string $path, string $icon = null);
    function removeFavorite($id);
    function getFavorites();
}

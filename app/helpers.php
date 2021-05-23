<?php

use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('storeLogo')) {
    /**
     * @param Request $request
     * @return string|null
     */
    function storeLogo(Request $request): string|null
    {
        if (
            empty($request->file('logo')) ||
            !$request->file('logo')->isValid() ||
            $request->file('logo')->getSize() === 0
        ) {
            return null;
        }

        $imageName = strtolower(str_replace(' ', '-', $request->company)) . '.' . $request->logo->extension();
        $imagePath = $request->logo->storePubliclyAs('public', $imageName);

        return str_replace('public/', '', $imagePath);
    }
}

<?php

function send_error($message, $errors = null, $code = 404)
{
    $response = [
        'status' => false,
        'message' => $message,
    ];
    !empty($errors) ? $response['errors'] = $errors : null;

    return response()->json($response, $code);
}

function send_response($message, $data = null, $code = 200)
{
    $response = [
        'status' => true,
        'message' => $message,
    ];
    !empty($data) ? $response['data'] = $data : null;

    return response()->json($response, $code);
}

// upload image
function imageUpload($request, $image, $directory)
{
    $doUpload = function ($image) use ($directory) {
        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extention = $image->getClientOriginalExtension();
        $imageName = $name . '_' . uniqId() . '.' . $extention;
        $image->move($directory, $imageName);
        return $directory . '/' . $imageName;
    };
    if (!empty($image) && $request->hasFile($image)) {
        $file = $request->file($image);
        if (is_array($file) && count($file)) {
            $imagesPath = [];
            foreach ($file as $key => $image) {
                $imagesPath[] = $doUpload($image);
            }
            return $imagesPath;
        } else {
            return $doUpload($file);
        }
    }

    return false;
}

// code generate
function generateCode($model, $prefix = '')
{
    $code = "000001";
    $model = '\\App\\Models\\' . $model;
    $num_rows = $model::count();
    if ($num_rows != 0) {
        $newCode = $num_rows + 1;
        $zeros = ['0', '00', '000', '0000', '00000'];
        $code = strlen($newCode) > count($zeros) ? $newCode : $zeros[count($zeros) - strlen($newCode)] . $newCode;
    }
    return $prefix . $code;
}

// make slug
function make_slug($string)
{
    return strtolower(preg_replace('/\s+/u', '-', trim($string)));
}

//credentials check
function credentials($username, $password)
{
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        return ['email' => $username, 'password' => $password];
    } else {
        return ['username' => $username, 'password' => $password];
    }
}

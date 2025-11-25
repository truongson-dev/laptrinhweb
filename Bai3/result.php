<?php
/**
 * Hàm kiểm tra tính hợp lệ của email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Hàm kiểm tra tính hợp lệ của mật khẩu
 */
function isValidPassword($password) {
    return strlen($password) >= 6;
}

/**
 * Hàm kiểm tra toàn bộ form
 */
function validateForm($email, $password) {
    $errors = [];
    
    if (empty($email)) {
        $errors['email'] = "Email không được để trống";
    } elseif (!isValidEmail($email)) {
        $errors['email'] = "Email không đúng định dạng";
    }
    
    if (empty($password)) {
        $errors['password'] = "Mật khẩu không được để trống";
    } elseif (!isValidPassword($password)) {
        $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự";
    }
    
    return [
        'isValid' => empty($errors),
        'errors' => $errors
    ];
}
?>
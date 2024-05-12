package com.temps.android.model

data class LoginResponse(
    val status: String,
    val sessionToken: String?,
    val userId: Int?
)

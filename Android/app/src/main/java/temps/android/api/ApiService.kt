package temps.android.api

import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.POST
interface ApiService {
    @POST("login")
    fun loginUser(@Body credentials: LoginCredentials): Call<LoginResponse>
}

data class LoginCredentials(val email: String, val password: String, val role: String = "Benevole")
data class LoginResponse(val status: String, val sessionToken: String, val userId: Int)

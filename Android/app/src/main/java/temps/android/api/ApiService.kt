package temps.android.api

import retrofit2.Call
import retrofit2.http.Body
import retrofit2.http.POST
//---------------------------------------///
import com.temps.android.model.PlanningEvent
import retrofit2.http.GET
import retrofit2.http.Path

interface ApiService {
    @POST("login")
    fun loginUser(@Body credentials: LoginCredentials): Call<LoginResponse>

    @GET("planning/{userId}")
    fun fetchPlannings(@Path("userId") userId: Int): Call<List<PlanningEvent>>

}



data class LoginCredentials(val email: String, val password: String, val role: String = "Benevole")
data class LoginResponse(val status: String, val sessionToken: String, val userId: Int)

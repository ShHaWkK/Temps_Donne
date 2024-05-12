import android.telecom.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.Body
import retrofit2.http.POST

interface ApiService {
    @POST("login")
    fun loginUser(@Body credentials: LoginCredentials): Call<LoginResponse>

    @POST("signup")
    fun signUpUser(@Body credentials: SignUpCredentials): Call<SignUpResponse>
}

object RetrofitClient {
    private const val BASE_URL = "http://localhost:8082/index.php/"

    val instance: ApiService by lazy {
        Retrofit.Builder()
            .baseUrl(BASE_URL)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
            .create(ApiService::class.java)
    }
}

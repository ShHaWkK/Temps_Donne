package temps.android

import android.os.Bundle
import android.widget.Button
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.google.android.material.textfield.TextInputEditText
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import temps.android.api.LoginCredentials
import temps.android.api.RetrofitClient
import temps.android.api.LoginResponse

class LoginActivity : AppCompatActivity() {
    private lateinit var emailEditText: TextInputEditText
    private lateinit var passwordEditText: TextInputEditText
    private lateinit var loginButton: Button

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)

        // Initialisation des vues
        emailEditText = findViewById(R.id.emailEditText)
        passwordEditText = findViewById(R.id.passwordEditText)
        loginButton = findViewById(R.id.loginButton)

        loginButton.setOnClickListener {
            val email = emailEditText.text.toString().trim()
            val password = passwordEditText.text.toString().trim()

            // Appel de la fonction de connexion
            login(email, password)
        }
    }

    private fun login(email: String, password: String) {
        RetrofitClient.instance.loginUser(LoginCredentials(email, password))
            .enqueue(object : Callback<LoginResponse> {
                override fun onResponse(call: Call<LoginResponse>, response: Response<LoginResponse>) {
                    if (response.isSuccessful && response.body()?.status == "success") {
                        Toast.makeText(applicationContext, "Connexion réussie", Toast.LENGTH_LONG).show()
                        // Vous pouvez sauvegarder le sessionToken et le userId ici
                        // et naviguer vers l'activité principale ou le fragment approprié
                    } else {
                        Toast.makeText(applicationContext, "Échec de la connexion", Toast.LENGTH_LONG).show()
                    }
                }

                override fun onFailure(call: Call<LoginResponse>, t: Throwable) {
                    Toast.makeText(applicationContext, "Erreur: ${t.message}", Toast.LENGTH_LONG).show()
                }
            })
    }
}

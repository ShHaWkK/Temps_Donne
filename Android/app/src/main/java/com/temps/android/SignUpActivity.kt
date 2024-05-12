package com.temps.android

import android.os.Bundle
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity
import com.temps.android.api.RetrofitClient
import com.temps.android.model.SignUpCredentials
import com.temps.android.model.SignUpResponse
import kotlinx.android.synthetic.main.activity_sign_up.*

class SignUpActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_sign_up)

        signUpButton.setOnClickListener {
            val email = emailEditText.text.toString().trim()
            val password = passwordEditText.text.toString().trim()
            if (email.isNotEmpty() && password.isNotEmpty()) {
                signUpUser(email, password)
            } else {
                Toast.makeText(this, "Email and password cannot be empty", Toast.LENGTH_SHORT).show()
            }
        }
    }

    private fun signUpUser(email: String, password: String) {
        val credentials = SignUpCredentials(email, password)
        RetrofitClient.instance.signUpUser(credentials).enqueue(object : retrofit2.Callback<SignUpResponse> {
            override fun onResponse(call: retrofit2.Call<SignUpResponse>, response: retrofit2.Response<SignUpResponse>) {
                if (response.isSuccessful && response.body()?.status == "success") {
                    Toast.makeText(this@SignUpActivity, "Sign up successful", Toast.LENGTH_LONG).show()
                    // Handle successful sign up, navigate to another activity or store session
                } else {
                    Toast.makeText(this@SignUpActivity, "Sign up failed: ${response.errorBody()?.string()}", Toast.LENGTH_LONG).show()
                }
            }

            override fun onFailure(call: retrofit2.Call<SignUpResponse>, t: Throwable) {
                Toast.makeText(this@SignUpActivity, "Error: ${t.localizedMessage}", Toast.LENGTH_LONG).show()
            }
        })
    }
}

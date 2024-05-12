package temps.android.ui

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.temps.android.adapters.PlanningAdapter
import com.temps.android.model.PlanningEvent
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import temps.android.R
import temps.android.api.RetrofitClient

class VolunteerScheduleFragment : Fragment() {

    private lateinit var recyclerView: RecyclerView
    private lateinit var adapter: PlanningAdapter

    //------------------------------------------------------------------------------------------------------//




    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_volunteer_schedule, container, false)
        recyclerView = view.findViewById(R.id.scheduleRecyclerView)
        recyclerView.layoutManager = LinearLayoutManager(context)
        adapter = PlanningAdapter(mutableListOf())  // Initialisez l'adapter avec une liste vide
        recyclerView.adapter = adapter

        fetchUserPlanning(1)  // Charge initiale des données

        return view
    }


    //------------------------------------------------------------------------------------------------------//


    private fun fetchUserPlanning(userId: Int) {
        RetrofitClient.instance.getUserPlanning(userId).enqueue(object : Callback<List<PlanningEvent>> {
            override fun onResponse(call: Call<List<PlanningEvent>>, response: Response<List<PlanningEvent>>) {
                if (response.isSuccessful) {
                    val planningEvents = response.body() ?: emptyList()
                    adapter.updateData(planningEvents)
                } else {
                    val errorBody = response.errorBody()?.string()
                    showError("Erreur Serveur: $errorBody")
                }
            }

            override fun onFailure(call: Call<List<PlanningEvent>>, t: Throwable) {
                showError("Erreur de connexion: ${t.localizedMessage}")
            }
        })
    }

    //------------------------------------------------------------------------------------------------------//


    private fun updateRecyclerView(planningEvents: List<PlanningEvent>) {
        (recyclerView.adapter as? PlanningAdapter)?.let {
            it.planningList = planningEvents.toMutableList()
            it.notifyDataSetChanged()
        } ?: showError("Erreur lors de la mise à jour de la liste")
    }
    //------------------------------------------------------------------------------------------------------//

    private fun showError(message: String) {
        Toast.makeText(context, message, Toast.LENGTH_LONG).show()
    }


}

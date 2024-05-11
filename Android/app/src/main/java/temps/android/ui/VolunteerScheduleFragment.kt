package temps.android.ui

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
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

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_volunteer_schedule, container, false)
        recyclerView = view.findViewById(R.id.scheduleRecyclerView)
        recyclerView.layoutManager = LinearLayoutManager(context)

        loadPlannings()

        return view
    }

    private fun loadPlannings() {
        RetrofitClient.instance.fetchPlannings(1).enqueue(object : Callback<List<PlanningEvent>> {
            override fun onResponse(call: Call<List<PlanningEvent>>, response: Response<List<PlanningEvent>>) {
                if (response.isSuccessful) {
                    recyclerView.adapter = PlanningAdapter(response.body()!!)
                }
            }

            override fun onFailure(call: Call<List<PlanningEvent>>, t: Throwable) {
                // Error handling here
            }
        })
    }
}

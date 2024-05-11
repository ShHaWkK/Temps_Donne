package temps.android.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import temps.android.adapters.R
import temps.android.model.PlanningEvent

class PlanningAdapter(private val planningList: List<PlanningEvent>) : RecyclerView.Adapter<PlanningAdapter.PlanningViewHolder>() {

    class PlanningViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        private val eventNameTextView: TextView = itemView.findViewById(R.id.eventName)

        fun bind(event: PlanningEvent) {
            eventNameTextView.text = event.name
            // Vous pouvez ajouter plus de propriétés à afficher ici
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): PlanningViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.planning_item, parent, false)
        return PlanningViewHolder(view)
    }

    override fun onBindViewHolder(holder: PlanningViewHolder, position: Int) {
        holder.bind(planningList[position])
    }

    override fun getItemCount() = planningList.size
}
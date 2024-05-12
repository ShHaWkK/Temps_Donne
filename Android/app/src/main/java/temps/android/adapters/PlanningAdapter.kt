package com.temps.android.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.temps.android.model.PlanningEvent
import temps.android.R

class PlanningAdapter(var planningList: MutableList<PlanningEvent>) :
    RecyclerView.Adapter<PlanningAdapter.PlanningViewHolder>() {

    fun updateData(newData: List<PlanningEvent>) {
        planningList.clear()
        planningList.addAll(newData)
        notifyDataSetChanged()
    }



    class PlanningViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        fun bind(event: PlanningEvent) {
            itemView.findViewById<TextView>(R.id.eventName).text = event.name
        }
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): PlanningViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.planning_item, parent, false)
        return PlanningViewHolder(view)
    }

    override fun onBindViewHolder(holder: PlanningViewHolder, position: Int) {
        holder.bind(planningList[position])
    }

    override fun getItemCount(): Int = planningList.size
}

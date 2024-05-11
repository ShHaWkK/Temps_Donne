package temps.android.model

data class PlanningEvent(
    val id: Int,
    val name: String,
    val description: String,
    val startTime: String,
    val endTime: String
)
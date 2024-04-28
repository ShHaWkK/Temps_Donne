
<?php
/*
*    Explications : Ce code est pour l'itinéraire le plus court
*
// Services/AStarService.php
*/

class AStarService {
    private $graph;

    public function __construct($graph) {
        $this->graph = $graph;
    }



    /*
    *   findShortestPath : Trouver le chemin le plus court
    */

    public function findShortestPath($start, $goal) {
        $openSet = new SplPriorityQueue();
        $openSet->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
        $openSet->insert($start, 0);

        $cameFrom = [];
        $gScore = array_fill_keys(array_keys($this->graph), PHP_INT_MAX);
        $gScore[$start] = 0;

        $fScore = array_fill_keys(array_keys($this->graph), PHP_INT_MAX);
        $fScore[$start] = $this->heuristic($start, $goal);

        while (!$openSet->isEmpty()) {
            $current = $openSet->top()['data'];
            $openSet->extract();

            if ($current === $goal) {
                return $this->reconstructPath($cameFrom, $current);
            }

            /*
            *   Sert à trouver le chemin le plus court
            */

            foreach ($this->graph[$current] as $neighbor => $cost) {
                $tentativeGScore = $gScore[$current] + $cost;
                if ($tentativeGScore < $gScore[$neighbor]) {
                    $cameFrom[$neighbor] = $current;
                    $gScore[$neighbor] = $tentativeGScore;
                    $fScore[$neighbor] = $gScore[$neighbor] + $this->heuristic($neighbor, $goal);
                    if (!$openSet->contains($neighbor)) {
                        $openSet->insert($neighbor, -$fScore[$neighbor]);
                    }
                }
            }
        }

        throw new Exception("Failed to find a path");
    }

    /*
    *   Sert à reconstruire le chemin le plus court
    */
    private function reconstructPath($cameFrom, $current) {
        $totalPath = [$current];
        while (isset($cameFrom[$current])) {
            $current = $cameFrom[$current];
            array_unshift($totalPath, $current);
        }
        return $totalPath;
    }

    /*
    *  heuristique : Calculer la distance entre deux points
    */
    private function heuristic($a, $b) {
        // Heuristic calculation here, for example, straight-line distance
        // You will need to implement this method based on your specific use case.
        // For geographical data, consider using Haversine formula or similar.


        return abs($b - $a);
    }
}
?>
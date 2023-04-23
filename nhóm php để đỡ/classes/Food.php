<?php

class Food {
    // attributes
    public $conn;

    // methods
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getfoods($limit = 9, $offset = 0, $category = "all food"){
        $sql = "SELECT * FROM foods";
        switch($category){
            case "main coursed":
                $sql .= " WHERE type='main coursed'";
                break;
            case "dessert":
                $sql .= ' WHERE type="dessert"';
                break;
            case "beverage":
                $sql .= ' WHERE type="beverage"';
                break;
            default:
                break;
        }

        $sql .= " LIMIT ?,?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }

    public function getfood($id_food){
        $sql = "SELECT * FROM foods WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id_food);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        return $result;
    }

    public function getToalAmountEachFoodType(){
        $sql = "SELECT COUNT(id) AS num_all,
                        SUM(CASE WHEN type='main coursed' THEN 1 END) AS num_main_courses,
                        SUM(CASE WHEN type='dessert' THEN 1 END) AS num_desserts,
                        SUM(CASE WHEN type='beverage' THEN 1 END) AS num_beverages
                FROM foods";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        $results["num_main_courses"] = (int)$results["num_main_courses"];
        $results["num_desserts"] = (int)$results["num_desserts"];
        $results["num_beverages"] = (int)$results["num_beverages"];

        return $results;
    }

    public function getTotalFoodSold(){
        $sql = "SELECT SUM(num_item) as total_food_sold
                FROM custom_foods";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        return $results['total_food_sold'];
    }

    public function foodOrderedEachType(){
        $sql = "SELECT SUM(CASE WHEN type='main coursed' THEN cs.num_item END) AS num_main_courses_sold,
                SUM(CASE WHEN type='dessert' THEN cs.num_item  END) AS num_desserts_sold,
                SUM(CASE WHEN type='beverage' THEN cs.num_item  END) AS num_beverages_sold
                FROM custom_foods cs JOIN foods f ON cs.food_id= f.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();
        $results = $results->fetch_assoc();

        $results["num_main_courses_sold"] = (string)$results["num_main_courses_sold"];
        $results["num_desserts_sold"] = (string)$results["num_desserts_sold"];
        $results["num_beverages_sold"] = (string)$results["num_beverages_sold"];

        return $results;
    }

    public function food_trending(){
        $sql = "SELECT name FROM (SELECT f.name, SUM(num_item) AS total_item 
                                FROM custom_foods cs JOIN foods f ON cs.food_id=f.id
                                GROUP BY f.id) AS T
                WHERE total_item >= ALL(SELECT total_item1 FROM (SELECT f1.name, SUM(num_item) AS total_item1
                            FROM custom_foods cs1 JOIN foods f1 ON cs1.food_id=f1.id
                            GROUP BY f1.id) AS Y)
                ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        $foodTrending['top_choices'] = $result['name'];

        $sql = "SELECT name FROM (SELECT f.name, SUM(num_item) AS total_item 
                                FROM custom_foods cs JOIN foods f ON cs.food_id=f.id
                                GROUP BY f.id) AS T
                WHERE total_item <= ALL(SELECT total_item1 FROM (SELECT f1.name, SUM(num_item) AS total_item1
                            FROM custom_foods cs1 JOIN foods f1 ON cs1.food_id=f1.id
                            GROUP BY f1.id) AS Y)
                ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        $foodTrending['least_favorite'] = $result['name'];

        $sql = "SELECT name FROM (SELECT f.name, SUM(f.price * cs.num_item) AS total_price 
                                FROM custom_foods cs JOIN foods f ON cs.food_id=f.id
                                GROUP BY f.id) AS T
                WHERE total_price >= ALL(SELECT total_price1 FROM (SELECT f1.name, SUM(f1.price * cs1.num_item) AS total_price1
                                                                    FROM custom_foods cs1 JOIN foods f1 ON cs1.food_id=f1.id
                                                                    GROUP BY f1.id) AS Y)
                ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        $foodTrending['most_profitable'] = $result['name'];

        $sql = "SELECT name FROM (SELECT f.name, SUM(f.price * cs.num_item) AS total_price 
                                FROM custom_foods cs JOIN foods f ON cs.food_id=f.id
                                GROUP BY f.id) AS T
                WHERE total_price <= ALL(SELECT total_price1 FROM (SELECT f1.name, SUM(f1.price * cs1.num_item) AS total_price1
                                                                    FROM custom_foods cs1 JOIN foods f1 ON cs1.food_id=f1.id
                                                                    GROUP BY f1.id) AS Y)
                ORDER BY name ASC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        $foodTrending['low_profitable'] = $result['name'];

        return $foodTrending;
    }

    function getFoodNotSoldYet(){
        $sql = "SELECT f.name
                FROM custom_foods cs RIGHT JOIN foods f ON cs.food_id=f.id
                WHERE cs.num_item IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->get_result();

        return $results->fetch_all(MYSQLI_ASSOC);
    }
}

?>
<?php

class Queue {
    protected $queue;

    public function __construct($initial = array() ) {

        $this->queue = $initial;
        // initialize the queue
    }

    public function enqueue( $item ) {
         if(count($this->queue) < 10)  {
            array_push( $this->queue, $item );
         }
    }

    public function getQueue() {
        return $this->queue;
    }

    public function dequeue() {
        if ( $this->isEmpty() ) {
            echo 'Your Queue is currently empty!';
        } else {
            array_shift($this->queue);
            echo 'Item removed!';
        }
    }


    public function isEmpty() {
        return empty( $this->queue );
    }

}

$queue = new Queue();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Queue</title>
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;"> 
    <form action="" method="POST" class="container p-5 bg-dark text-white" style="max-width: 500px;">
    <h1>Queue</h1>
    <hr class="bg-light border-1 border-top border-light">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $item = $_POST['item'];
        $action_type = $_POST['action_type'];
        if(isset($_POST['items'])) {
            for($i = 0; $i <= count($_POST['items']); $i++) {
                if(!empty($_POST['items'][$i])) {
                    $queue->enqueue($_POST['items'][$i]);
                }
             }
        }
        switch ($action_type) {
            case 'enqueue':
                if(!empty($item)) {
                    $queue->enqueue($item);
                    if(count($queue->getQueue()) < 10) {
                        echo 'Item added Successfully!';
                    } else {
                        echo "Your Queue is full!";
                    }
                    
                }
                break;
            case 'dequeue':
                $queue->dequeue();
                break;
        }
    } else {
        echo 'Your Queue is currently empty!';
    }
    ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
        <div class="d-flex align-items-center justify-content-between">
           <input autofocus="true' type="text" name="item" class="form-control form-control-lg" placeholder="Enter Item">&nbsp;<button type="submit" class="btn btn-lg btn-success">Enqueue</button>&nbsp;
           <button type="submit" class="btn btn-lg btn-danger">Dequeue</button>
           <input type="hidden" id="action_type" name="action_type">
        </div>
        <div class="p-5 overflow-auto bg-light mt-3 rounded text-dark" style="max-height: 300px">
<?php
        foreach ($queue->getQueue() as $value) {
            echo '<div class="alert alert-info p-2">' . $value . '</div>';
            echo '<input type="hidden" name="items[]" value="' . $value . '"/>';
        }

?>  
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script>
        (() => {
            let btns = document.querySelectorAll('.btn')
            btns.forEach(btn => {
                btn.onclick = function() {
                    document.querySelector('#action_type').value = this.innerHTML.toLowerCase();
                }
            })
        })()
    </script>
</body>
</html>
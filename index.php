<?php
require "config.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["age"])) {
    $name = trim($_POST["name"]);
    $age = intval($_POST["age"]);

    if ($name !== "" && $age > 0) {
        $stmt = $conn->prepare("INSERT INTO users (name, age, status) VALUES (?, ?, 0)");
        $stmt->bind_param("si", $name, $age);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect so refreshing the page doesn't resubmit the form
    header("Location: index.php");
    exit;
}

// Fetch all rows for the table
$result = $conn->query("SELECT id, name, age, status FROM users ORDER BY id");
$total = $result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Member Registry</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="page">

        <header class="page-header">
            <h1>Member Registry</h1>
        </header>

        <section class="card form-card">
            <form method="POST" action="index.php" class="entry-form">
                <div class="field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Full name" required>
                </div>
                <div class="field field-age">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" min="1" placeholder="0" required>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </section>

        <section class="card table-card">
            <div class="table-card-head">
                <h2>Roster</h2>
                <span class="count-badge"><?php echo $total; ?> member<?php echo $total === 1 ? "" : "s"; ?></span>
            </div>

            <table id="usersTable">
                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th>Name</th>
                        <th class="col-age">Age</th>
                        <th class="col-status">Status</th>
                        <th class="col-action">Active</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()):
                        $isActive = (int)$row['status'] === 1;
                    ?>
                    <tr id="row-<?php echo $row['id']; ?>">
                        <td class="col-id mono"><?php echo str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>
                        <td class="name-cell"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td class="col-age mono"><?php echo $row['age']; ?></td>
                        <td class="col-status">
                            <span class="status-pill <?php echo $isActive ? 'is-active' : 'is-inactive'; ?>">
                                <span class="status-dot"></span>
                                <span class="status-text"><?php echo $isActive ? 'Active' : 'Inactive'; ?></span>
                            </span>
                        </td>
                        <td class="col-action">
                            <label class="switch">
                                <input type="checkbox" class="toggle-input" data-id="<?php echo $row['id']; ?>" <?php echo $isActive ? 'checked' : ''; ?>>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

    </div>

    <script src="script.js"></script>
</body>
</html>
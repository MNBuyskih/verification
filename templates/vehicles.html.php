
<h2>Vehicles</h2>

<p><button onclick="newvehicle()">New vehicle</button> </p>
<table class="forwindow">

    <th>ID</th><th>Number</th><th>VIN<th>Owner</th><th>Edit</th><th>Delete</th>
    <tr>
        <?php foreach($vehicles as $vehicle) : ?>

            <td> <?= htmlspecialchars($vehicle['id'], ENT_QUOTES, 'UTF-8') ?></td>           
            <td> <?= htmlspecialchars($vehicle['number'], ENT_QUOTES, 'UTF-8') ?></td>
            <td> <?= htmlspecialchars($vehicle['vin'], ENT_QUOTES, 'UTF-8') ?></td>
            <td> <?= htmlspecialchars($vehicle['owner'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>               
                    <a href="/vehicles/edit?id=<?= $vehicle['id'] ?>"> Edit</a>
                           
            </td>
            <td>
                    <form action="/vehicles/delete" method="post">
                        <input type="hidden" name="id" value="<?= $vehicle['id'] ?>">
                        <input type="submit" value="Delete">
                    </form>                    
            </td>
    </tr>
<?php endforeach; ?>
</table>
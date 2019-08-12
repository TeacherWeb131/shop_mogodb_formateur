<div>
    <h1>Commande</h1><br>
    Identifiant : <p><?= $order->getId() ?></p><br>
    Commandé le : <p><?= $order->getCreated_at() ?></p><br>
    Total HT : <p><?= $order->getTotal_ht() ?></p><br>
    Total TTC : <p><?= $order->getTotal_ttc() ?></p><br>
</div>

<div>
    <table>
        <tr>
            <th>Quantité Commandé</th>
            <th>prix unitaire</th>
            <th>Total</th>
            <th>Produit commandé</th>
        </tr>

        <?php foreach ($order->getOrder_details() as $o) : ?>
        <tr>
            <td><?= $o->getQuantity_ordered() ?></td>
            <td><?= $o->getPrice_each() ?></td>
            <td><?= $o->getTotal_price() ?></td>
            <td><a href="<?= REQUEST_URL ?>/product/show/<?= $o->getProduct_id() ?>">Afficher le produit</a></td>
        </tr>
        <?php endforeach ?>
    </table>

</div>
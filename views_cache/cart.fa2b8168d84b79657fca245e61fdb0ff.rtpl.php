<?php if(!class_exists('Rain\Tpl')){exit;}?><table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Description</th>
            <th scope="col">Amount</th>
            <th scope="col">Quantity</th>
          </tr>
        </thead>
        <tbody>
        <?php $counter1=-1;  if( isset($items) && ( is_array($items) || $items instanceof Traversable ) && sizeof($items) ) foreach( $items as $key1 => $value1 ){ $counter1++; ?>

            <tr>
                <th scope="row"><?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                <td><?php echo htmlspecialchars( $value1["description"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td><?php echo htmlspecialchars( $value1["amount"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td><?php echo htmlspecialchars( $value1["quantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
            </tr>
          <?php } ?>

          
        </tbody>
      </table>
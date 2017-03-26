 <?php
class ModelAccountTrackingOrder extends Model {
	// Get Resi Code
	public function getResi($data) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "`order` WHERE order_id='" . $this->db->escape($data['order_id']) . "'");
		return $query->rows;
	}
}
?>

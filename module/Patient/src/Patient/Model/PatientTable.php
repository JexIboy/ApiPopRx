<?php
namespace Patient\Model;

use Zend\Db\TableGateway\TableGateway;

class PatientTable {

	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll() {
		$resultSet = $this->tableGateway->select();

		$result = $this->toArray($resultSet);

		return array(
			'status' => 'success',
			'data' => $result
		);
	}

	public function getPatient($id) {
		$id  	= (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row 	= $rowset->current();

		if (!$row) {
			return array(
				'status' 	=> 'error',
				'error'		=> 'Could not find row $id'
			);
		}

		return array(
			'status' 	=> 'success',
			'data'		=> $row
		);
	}

	public function savePatient(Patient $patient) {
		$data = array(
			'name' 			=> $patient->name,
			'gender'		=> $patient->gender,
			'birth_year'	=> $patient->birth_year,
			'condition'  	=> $patient->condition,
			'adherence'		=> $patient->adherence
		);

		$id = (int) $patient->id;

		if ($id == 0) {

			$this->tableGateway->insert($data);

			return array(
				'status' => 'success'
			);

		} else {

			$patient = $this->getPatient($id);

			if ($patient->status === 'success') {

				$this->tableGateway->update($data, array('id' => $id));

				return $this->getPatient($id);

			} else {

				return array(
					'status'	=> 'error',
					'error'		=> 'Patient id does not exist'
				);

			}
		}
	}

	public function deletePatient($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}

	public function toArray($resultSet) {
		$result = array();

		foreach ($resultSet as $value) {
			$result[] = $value;
		}

		return $result;
	}
}
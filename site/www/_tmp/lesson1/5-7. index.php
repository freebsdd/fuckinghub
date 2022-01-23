<?php
	// �������� ������� ���������, ����������� ��� ���� ���� �������� ������� ������� � 1 �������
	namespace p1;
		// ���������� ������
		class A {
			// ���������� ��������� �������
		    public function foo() {
		    	// ����������� ����������� ����������
		        static $x = 0;
		        // ��������� ���������� ($x = $x + 1) � ����� � �� �����
		        echo ++$x;
		    }
		}
	
	echo "p1: ";
	// �������� ������
	$a1 = new A();
	// �������� ������
	$a2 = new A();
	// ����� �������
	$a1->foo();		// ������� 1
	// ����� �������
	$a2->foo();		// ������� 2
	// ����� �������
	$a1->foo();		// ������� 3
	// ����� �������
	$a2->foo();		// ������� 4
	
	/*
	 * ��� ���������� ������, ��� ���������� static ��� �������� ������� � ������� ����������� ������ 1 ���, � ��� ��������� ������ ������� ������������� ����� ��� ��� ��� ���� ������� � ���������� ������� ��������
	 */
	 
	// �������� ������� ���������, ����������� ��� ���� ���� �������� ������� ������� � 1 �������
	namespace p2;
	 
	class A {
	    public function foo() {
	        static $x = 0;
	        echo ++$x;
	    }
	}
	// �������� ������� ������, ������������ ����� A
	class B extends A {
	}
	echo "<br>p2: ";
	$a1 = new \p2\A();
	$b1 = new \p2\B();
	$a1->foo();		// ������� 1
	$b1->foo();		// ������� 1
	$a1->foo();		// ������� 2
	$b1->foo();		// ������� 2
	
	/*
	 * ��� ���������� ������, ��� �������� 2 ������ ������, ��� ������ ������� ����������, ����� � � ����� �, ���������� static � ������� ���� � �� ����� "�����" ������ ��� ������� � ���������������� ���� ������ � ��� ������.
	 */
	 
	 
	namespace p3;
	
	class A {
		// function __construct($a, $c){;}
	    public function foo() {
	        static $x = 0;
	        echo ++$x;
	    }
	}
	class B extends A {
	}
	echo "<br>p3: ";
	$a1 = new A;
	$b1 = new B;
	$a1->foo();		// ������� 1
	$b1->foo();		// ������� 1
	$a1->foo();		// ������� 2
	$b1->foo();		// ������� 2
	
	/*
	 * ��������� ���������� ����� ��� � namespace p2, ������ �� ����������, �� ����������� ���������� ������ � �������, ���� �� � ��� ��� __construct � �������� �����������, ���� �� ��������� ������, � �.�. � ���, ����� ������� ����� ��� ������. ���������������� __construct � �������.
	 */
?>
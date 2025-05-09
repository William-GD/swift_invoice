<?php
require_once '../../config/setup.php';
requireAuth();

$page_title = "Datos de la Empresa - Swift Invoice";
require_once '../../includes/header.php';

$db = new Database();
$conn = $db->connect();

// Obtener datos de la empresa (asumimos solo una empresa)
$stmt = $conn->query("SELECT * FROM companies LIMIT 1");
$company = $stmt->fetch(PDO::FETCH_ASSOC);

// Mostrar errores si existen
$errors = [];
if (isset($_SESSION['company_form_errors'])) {
    $errors = $_SESSION['company_form_errors'];
    unset($_SESSION['company_form_errors']);//bngugrundngngnd9ugn
    
    // Usar los datos enviados en lugar de los de la base de datos
    if (isset($_SESSION['company_form_data'])) {
        $company = $_SESSION['company_form_data'];
        unset($_SESSION['company_form_data']);
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">Datos de la Empresa</h2>
    </div>
    
    <div class="card-body">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-error"><?php echo $errors['general']; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="save.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="business_name">Razón Social:</label>
                        <input type="text" id="business_name" name="business_name" class="form-control" 
                               value="<?php echo htmlspecialchars($company['business_name'] ?? ''); ?>" required>
                        <?php if (isset($errors['business_name'])): ?>
                            <span class="error-text"><?php echo $errors['business_name']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="rfc">RFC:</label>
                        <input type="text" id="rfc" name="rfc" class="form-control" 
                               value="<?php echo htmlspecialchars($company['rfc'] ?? ''); ?>" required>
                        <?php if (isset($errors['rfc'])): ?>
                            <span class="error-text"><?php echo $errors['rfc']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="fiscal_address">Dirección Fiscal:</label>
                        <textarea id="fiscal_address" name="fiscal_address" class="form-control" 
                                  rows="3" required><?php echo htmlspecialchars($company['fiscal_address'] ?? ''); ?></textarea>
                        <?php if (isset($errors['fiscal_address'])): ?>
                            <span class="error-text"><?php echo $errors['fiscal_address']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Teléfono:</label>
                        <input type="tel" id="phone" name="phone" class="form-control" 
                               value="<?php echo htmlspecialchars($company['phone'] ?? ''); ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="<?php echo htmlspecialchars($company['email'] ?? ''); ?>">
                        <?php if (isset($errors['email'])): ?>
                            <span class="error-text"><?php echo $errors['email']; ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="tax_regime">Régimen Fiscal:</label>
                        <input type="text" id="tax_regime" name="tax_regime" class="form-control" 
                               value="<?php echo htmlspecialchars($company['tax_regime'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="legal_representative">Representante Legal:</label>
                        <input type="text" id="legal_representative" name="legal_representative" class="form-control" 
                               value="<?php echo htmlspecialchars($company['legal_representative'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="logo">Logo:</label>
                        <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
                        <?php if (isset($errors['logo'])): ?>
                            <span class="error-text"><?php echo $errors['logo']; ?></span>
                        <?php endif; ?>
                        
                        <?php if (!empty($company['logo_path'])): ?>
                            <div class="current-logo mt-2">
                                <p>Logo actual:</p>
                                <img src="<?php echo '/swift_invoice/' . $company['logo_path']; ?>" 
                                     alt="Logo de la empresa" style="max-width: 200px; max-height: 100px;">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-success">Guardar Datos</button>
        </form>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>
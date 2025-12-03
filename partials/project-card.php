<?php
// This file is included in the projects section
// $project variable is available from the loop
?>
<div class="project-card" data-project-id="<?php echo $project['id']; ?>">
    <div class="project-image">
        <?php if (!empty($project['image_url'])): ?>
            <img src="<?php echo $project['image_url']; ?>" 
                 alt="<?php echo htmlspecialchars($project['title']); ?>"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <?php endif; ?>
        <?php if (empty($project['image_url'])): ?>
            <div class="project-placeholder" style="display: flex;">
                <i class="fas fa-code"></i>
            </div>
        <?php endif; ?>
        <div class="project-status <?php echo getStatusBadgeClass($project['status']); ?>">
            <?php echo ucfirst(str_replace('_', ' ', $project['status'])); ?>
        </div>
        <?php if ($project['featured']): ?>
            <div class="featured-badge">
                <i class="fas fa-star"></i> Featured
            </div>
        <?php endif; ?>
    </div>
    <div class="project-content">
        <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
        <p class="project-category"><?php echo htmlspecialchars($project['category']); ?></p>
        <p class="project-description"><?php echo htmlspecialchars($project['short_description']); ?></p>
        
        <?php 
        $technologies = json_decode($project['technologies'] ?? '[]', true);
        if (is_array($technologies) && !empty($technologies)): 
        ?>
            <div class="project-technologies">
                <?php foreach(array_slice($technologies, 0, 4) as $tech): ?>
                    <span class="tech-tag"><?php echo htmlspecialchars(trim($tech)); ?></span>
                <?php endforeach; ?>
                <?php if (count($technologies) > 4): ?>
                    <span class="tech-tag">+<?php echo count($technologies) - 4; ?> more</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="project-links">
            <?php if (!empty($project['project_url'])): ?>
                <a href="<?php echo htmlspecialchars($project['project_url']); ?>" 
                   target="_blank" class="btn-link">
                    <i class="fas fa-external-link-alt"></i> Live Demo
                </a>
            <?php endif; ?>
            <?php if (!empty($project['github_url'])): ?>
                <a href="<?php echo htmlspecialchars($project['github_url']); ?>" 
                   target="_blank" class="btn-link">
                    <i class="fab fa-github"></i> Code
                </a>
            <?php endif; ?>
            <button class="btn-view-details" onclick="openProjectModal(<?php echo $project['id']; ?>)">
                View Details
            </button>
        </div>
    </div>
</div>
ALTER TABLE `ufg_questionario`.`respostas` 
ADD COLUMN `id_questionario` INT NULL AFTER `id_resposta`,
ADD INDEX `FK_RESPOSTA_QUESTIONARIO_idx` (`id_questionario` ASC),
ADD INDEX `FK_REPOSTA_PERGUNTA_idx` (`id_pergunta` ASC);

ALTER TABLE `ufg_questionario`.`respostas` 
ADD CONSTRAINT `FK_RESPOSTA_QUESTIONARIO`
  FOREIGN KEY (`id_questionario`)
  REFERENCES `ufg_questionario`.`questionario` (`id`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE,
ADD CONSTRAINT `FK_REPOSTA_PERGUNTA`
  FOREIGN KEY (`id_pergunta`)
  REFERENCES `ufg_questionario`.`perguntas` (`id_pergunta`)
  ON DELETE RESTRICT
  ON UPDATE CASCADE;


ALTER TABLE `respostas`
	ADD COLUMN `resposta_select` INT NULL AFTER `resposta_codigo`;


-- ###### Consulta SQL para recuperar as respostas

SELECT p.id_pergunta,
       p.ordem,
       p.enunciado,
       IFNULL(r.resposta, ope.texto) AS resposta
FROM respostas r
INNER JOIN perguntas p ON r.id_pergunta = p.id_pergunta
LEFT JOIN opcoes_escolha ope ON r.resposta_codigo = ope.id
WHERE r.id_questionario = 1
  AND (p.tipo <> 6
       OR p.tipo IS NULL)
UNION ALL
SELECT p.id_pergunta,
       p.ordem,
       p.enunciado,
       est.nome AS resposta
FROM respostas r
INNER JOIN perguntas p ON r.id_pergunta = p.id_pergunta
INNER JOIN glb_estado est ON r.resposta_select = est.codigo
AND p.model = 'select-estado'
WHERE r.id_questionario = 1
  AND p.tipo = 6
UNION ALL
SELECT p.id_pergunta,
       p.ordem,
       p.enunciado,
       mun.nome AS resposta
FROM respostas r
INNER JOIN perguntas p ON r.id_pergunta = p.id_pergunta
INNER JOIN glb_municipio mun ON r.resposta_select = mun.codigo_ibge
AND p.model = 'select-municipios'
WHERE r.id_questionario = 1
  AND p.tipo = 6
UNION ALL
SELECT p.id_pergunta,
       p.ordem,
       p.enunciado,
       esc.NO_ENTIDADE AS resposta
FROM respostas r
INNER JOIN perguntas p ON r.id_pergunta = p.id_pergunta
INNER JOIN glb_escolas esc ON r.resposta_select = esc.CO_ENTIDADE
AND p.model = 'select-escolas'
WHERE r.id_questionario = 1
  AND p.tipo = 6
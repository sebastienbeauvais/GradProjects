# Heart Disease Project R Code

# packages
library(caret)
library(MASS)
library(e1071)
library(psych)
library(corrplot) 
library(corrgram)
library(ISLR)
library(pROC)

# setting working Directory
setwd("D:/SDSU/2022/BDA_749/Project/")

# reading in CSV 
hr.data <- read.csv('heart_2020_edited.csv') 

# downsizing dataset to run (computational limitation)
# this randomly selects 15k rows (origianl over 300k)
set.seed(101) # setting seed so we are all sampling the same data
hd.sample <- sample(nrow(hr.data), nrow(hr.data) * .05)

# Creating downsample dataframe
hd.sub <- hr.data[hd.sample,] # we will be modeling with this

# Descriptive stats of data
# dependent variable is HeartDisease
# independent is everything else
str(hd.sub)
summary(hd.sub)
View(hd.sub)
table(hd.sub$Sex, hd.sub$HeartDisease)

# dependent var is Heart Disease

# plot of distribution on the IV
plot(BMI ~ PhysicalHealth, data = hd.sub)

# Dummies
# we will need to convert some vars to dummies
hd.sub.dmodel <- dummyVars( ~., data=hd.sub, fullRank=T)
hr.d <- as.data.frame(predict(hd.sub.dmodel, hd.sub))
View(hr.d)
str(hr.d)



names(hr.d) <- make.names(names(hr.d), unique=TRUE) # renaming columns for later use
str(hr.d)  # Checking new names
pairs(hr.d$HeartDisease ~ hr.d$BMI + hr.d$Smoking) # margins too large to display all vars
# Making a correlation matrix on the variables
#cor(hr.d)

#splitting the model into train and testing (80/20 split)
set.seed(199)
train.index <- sample(nrow(hr.d), nrow(hr.d) * .8)

# Creating test and training data frames
hr.train <- hr.d[train.index,] # we will be modeling with this
hr.test <- hr.d[-train.index,] # this is ONLY for testing (we will cross validate later)

dev.off()
plot.new()
# take a quick look overall
pairs.panels(hr.train) # getting issues with plotting too large

# identifying possible skew values
skewVal <- apply(hr.train, 2, skew)
skewSE <- sqrt(6/nrow(hr.train))
abs(skewVal/skewSE) > 2 # comes out with everything as TRUE

multi.hist(hr.train[,abs(skewVal)/skewSE > 2]) # BMI left skewed
par(mfrow=c(1,1)) # resetting plot display to 1
###### need to get age category counts instead of what we have to see if skew #####

# identifying correlated predictors
hr.cor <- cor(hr.train[,-1]) # omitting DV
hr.cor
corrplot(hr.cor, order="hclust") # ATM this tells us nothing
corrgram(hr.cor, upper.panel = panel.cor, lower.panel = panel.pie) # this was slightly more useful than corrplot

#remove zero or near zero variance (train data)
hr.novar.train <- nearZeroVar(hr.train)
hr.novar.train
names(hr.train)
#there are several near zero or zero variance predictors that we need to remove
hr.train <- hr.train[,-c(5,22,25,27,29,33,37)]
names(hr.train)
nrow(hr.train)
ncol(hr.train)

#remove zero or near zero variance (test data)
hr.novar.test <- nearZeroVar(hr.test)
hr.novar.test
names(hr.test)
#there are several near zero or zero variance predictors that we need to remove
hr.test <- hr.test[,-c(5,22,25,27,29,33,37)]
names(hr.test)
nrow(hr.test)
ncol(hr.test)


#train() isnt happy with how the data is present
# we will change the class to a factor so it can run...
# we also have to edit column names to be syntactically correct..
hr.d$HeartDisease <- factor(hr.d$HeartDisease)
hr.train$HeartDisease <- factor(hr.train$HeartDisease) # have to make IV factor
hr.test$HeartDisease <- factor(hr.test$HeartDisease) # have to make IV factor
levels(hr.d$HeartDisease) <- c("Yes", "No")
levels(hr.train$HeartDisease) <- c("Yes", "No")
levels(hr.test$HeartDisease) <- c("Yes", "No")

# setting control function for resampling and binary classification performance
# using 10 fold cross validation
ctrl <- trainControl(method = "cv", number=10, summaryFunction=twoClassSummary,
                     classProbs=T, savePredictions = T)

#################################################################################
########################## Supervised Models ####################################
#################################################################################
# logistic regression
set.seed(199)
d.log <- train(HeartDisease ~ ., data=hr.train, method="glm", family="binomial",
               metric="ROC", trControl=ctrl)
d.log
varImp(d.log) # variable importance
summary(d.log)
confusionMatrix(d.log$pred$pred, d.log$pred$obs) # Calculating resample accuracy

# KNN - NOTE: This one takes time to run
set.seed(199)
d.knn <- train(HeartDisease ~ ., data=hr.train, method="knn", metric="ROC",
               trControl=ctrl, tuneLength=10) # Caret decides 10 best parameters
d.knn
plot(d.knn) # looks like 11 neighbors would be a good fit
getTrainPerf(d.knn) 
confusionMatrix(d.knn$pred$pred, d.knn$pred$obs) # high false positive rate. may benefit balancing data

# LDA
set.seed(199)
d.lda <-  train(HeartDisease ~ ., data=hr.train, method="lda", metric="ROC", 
                trControl=ctrl)
d.lda
varImp(d.lda)
getTrainPerf((d.lda))
confusionMatrix(d.lda$pred$pred, d.lda$pred$obs) #take averages

# QDA
set.seed(199)
d.qda <-  train(HeartDisease ~ ., data=hr.train, method="qda", metric="ROC", 
                trControl=ctrl)
d.qda
getTrainPerf(d.qda)

# Comparing all models
d.models <- list("logit"=d.log, "lda"=d.lda, "qda"=d.qda,
                 "knn"=d.knn)
d.resamples = resamples(d.models)

# plotting performance comparison
bwplot(d.resamples, metric="ROC") 
bwplot(d.resamples, metric="Sens") #predicting default dependant on threshold
bwplot(d.resamples, metric="Spec") 

# Calculate ROC Curve on data
d.log.roc<- roc(response= d.log$pred$obs, predictor=d.log$pred$Yes)
d.lda.roc<- roc(response= d.lda$pred$obs, predictor=d.lda$pred$Yes)
d.qda.roc<- roc(response= d.qda$pred$obs, predictor=d.qda$pred$Yes)
#when model has parameters make sure to select final parameter value
d.knn.roc<- roc(response= d.knn$pred[d.knn$pred$k==23,]$obs, 
                predictor=d.knn$pred[d.knn$pred$k==23,]$Yes) 

#build to combined ROC plot with resampled ROC curves
plot(d.log.roc, legacy.axes=T)
plot(d.lda.roc, add=T, col="Blue")
plot(d.qda.roc, add=T, col="Green")
plot(d.knn.roc, add=T, col="Red")
legend(x=.2, y=.7, legend=c("Logit", "LDA", "QDA", "KNN"), 
       col=c("black","blue","green","red"),lty=1)

#logit looks like the best choice its most parsimonious and equal ROC to LDA, QDA, and KNN

confusionMatrix(d.log$pred$pred, d.log$pred$obs)

# Extracting threshold from ROC
d.log.Thresh <- coords(d.log.roc, x="best", best.method="closest.topleft")
d.log.Thresh # for some reason running this throws error
# threshold at 0.914. When using the threshold it can no longer calculate matrix? so I set manually
d.log.Thresh <- 0.9119507 # setting threshold to 91.1% manually to test performance

#lets make new predictions with this cut-off and recalculate confusion matrix

d.log.newpreds <- factor(ifelse(d.log$pred$Yes > d.log.Thresh[[1]], "Yes", "No"))

#recalculate confusion matrix with new cut off predictions
confusionMatrix(d.log.newpreds, d.log$pred$obs) # Now we see that true negative is much better

########################### TEST data performance ############################
test.pred.prob <- predict(d.log, hr.test, type="prob")

test.pred.class <- predict(d.log, hr.test) # predict classes with .5 cutoff

# calc confusion matrix
confusionMatrix(test.pred.class, hr.test$HeartDisease)

# ROC of test and training performance
test.log.roc <- roc(response=hr.test$HeartDisease, predictor=test.pred.prob[[1]])

# assume positive class is yes
plot(test.log.roc, col="red", legacy.axes=T)
plot(d.log.roc, add=T, col="blue")
legend(x=.2, y=.7, legend=c("Test Logit", "Train Logit"), col=c("red", 
                                                                "blue"), lty=1)
# Test performance is slightly higher than train
auc(test.log.roc)
auc(d.log.roc)

# Calculate test confusion Matrix
test.pred.class.newthresh <- factor(ifelse(test.pred.prob[[1]] > d.log.Thresh[1], "Yes", "No"))

#recalculate confusion matrix with new cut off predictions
confusionMatrix(test.pred.class.newthresh, hr.test$HeartDisease) # after setting threshold we still get 75%
# accuracy in predicting Heart Disease. Is this good enough?



#################################################################################
############################ Unsupervised Models ################################
#################################################################################
# neither seem particularly useful at this time..


# copying dataframe for unsupervised editing
hr.us <- hr.d

# remove response variable
hr.us$HeartDisease <- NULL

#Lets fit PCA making sure to scale
hr.pca <- prcomp(hr.us, scale=TRUE)

# view scaling centers and SD
hr.pca$center
hr.pca$scale

# view the pca loading's one PC for each 37 variables
hr.pca$rotation

# view biplot of first two components
biplot(hr.pca, scale=0) # too much going on, maybe feature selection will help?

# variance explained by each component squaring standard deviation
pca.var <- hr.pca$sdev^2

# proportion of variance explained
pve <- pca.var/sum(pca.var)

# scree plot, variance explained by component
plot(pve, xlab="PCA", ylab="Prop of Variance Explained", ylim=c(0,1), type="b") # variance too low. Why?

# cumulative variance explained
# scree plot, variance explained by component
plot(cumsum(pve), xlab="PCA", ylab="Cumulative Prop of Variance Explained",
     ylim=c(0,1), type="b")

# grab the first five PCs
hr.pca$x[,1:5]

# shorter version of summarizing variance
summary(hr.pca)
plot(hr.pca)

# K-Means Clustering
set.seed(199)
#k=2 with 20 random initialization
hr.kmeans.2 <- kmeans(hr.us, 2, nstart=20)
hr.kmeans.2
# seeking to reduce within sum of squares error
hr.kmeans.2$tot.withinss

#k=3
hr.kmeans.3 <- kmeans(hr.us, 3, nstart=20)
hr.kmeans.3$tot.withinss

# lets find optimal K through WSS
wss <- numeric(10)
for (k in 1:10){
  clust <- kmeans(hr.us, center=k, nstart=25)
  
  wss[k] <- sum(clust$withinss)
}

# view plot of wss by cluster size
# 3-4 looks good
plot(1:10, wss, type="b", xlab="Number of Clusters", ylab="Within Sum of Squares")

hr.kmeans.4 <- kmeans(hr.us, 4, nstart=20)

library(cluster)
# plot the cluster by first two PCAs to reduce dimensions
clusplot(hr.us, hr.kmeans.4$cluster, color=TRUE,shade=TRUE,
         labels=0, lines=0)

# hierarchical clusters scaling before calculating distance and clustering
hr.hc.complete <- hclust(dist(scale(hr.us)), method = "complete")

#plot the dendograms
plot(hr.hc.complete)
#select vertical cut to create clusters
cutree(hr.hc.complete, k=4) # 4 groups
#cutree(hr.hc.complete, h=1600) # or by height
plot(hr.hc.complete)










































